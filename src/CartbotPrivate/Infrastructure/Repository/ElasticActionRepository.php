<?php

namespace CartbotPrivate\Infrastructure\Repository;

use Elastica\Aggregation\DateHistogram;
use Elastica\Aggregation\Terms;
use Elastica\Document;
use Elastica\Query;
use Elastica\Query\Prefix;
use Elastica\Query\Term;
use Elastica\Result;
use Elastica\Search;
use Elastica\Type\Mapping;
use CartbotPrivate\Application\Outputs\Admin\FindEventsOut;
use CartbotPrivate\Domain\Action\Action;
use CartbotPrivate\Domain\Action\ActionRepository;
use CartbotPrivate\Domain\Action\ActionType;
use CartbotPrivate\Domain\Action\FilterActions;
use CartbotPrivate\Domain\Action\SortActions;

class ElasticActionRepository implements ActionRepository
{
    private const INDEX_NAME = 'actions';

    private $elasticClient;

    public function __construct(ElasticClient $elasticClient)
    {
        $this->elasticClient = $elasticClient;
    }

    public function indexExist(): bool
    {
        $elasticaIndex = $this->elasticClient->getIndex(self::INDEX_NAME);
        return $elasticaIndex->exists();
    }

    public function createIndex(): void
    {
        $index = $this->elasticClient->getIndex(self::INDEX_NAME);
        $index->create(
            [
                'number_of_shards' => 3,
                'number_of_replicas' => 1
            ]
        );

        $type = $index->getType(self::INDEX_NAME);
        $mapping = new Mapping();
        $mapping->setType($type);
        $mapping->setProperties([
            'id' => ['type' => 'keyword'],
            'date' => ['type' => 'date', "format" => "yyyy-MM-dd HH:mm:ss"],
            'idClient' => ['type' => 'long'],
            'idUser' => ['type' => 'long'],
            'chatType' => ["type" => "text", "fields" => ["keyword" => ["type" => "keyword"]]],
            'type' => ['type' => 'keyword'],
            "data" => ["type" => "text", "fields" => ["keyword" => ["type" => "keyword"]]]
        ]);
        $mapping->send();
    }

    public function saveAction(Action $action): void
    {
        $index = $this->elasticClient->getIndex(self::INDEX_NAME);
        $type = $index->getType(self::INDEX_NAME);
        $document = new Document($action->id(), $action->toArray());
        $type->addDocuments([$document]);
        $type->getIndex()->refresh();
    }

    public function getLastEvents(string $idClient): array
    {
        $today = new \DateTimeImmutable();
        $query = new Query;
        $query->setSize(0);
        $bool = $this->boolRangeAndClient($today, $today, $idClient);
        $query->setQuery($bool);

        $aggDateName = "date_range_agg";
        $aggTypeName = "by_type";
        $dateHist = new DateHistogram($aggDateName, 'date', 'hour');
        $dateHist->setFormat('H');
        $sum = (new Terms($aggTypeName))->setField('type');
        $dateHist->addAggregation($sum);
        $query->addAggregation($dateHist);

        $search = new Search($this->elasticClient);
        $search->addIndices([self::INDEX_NAME]);
        $search->setQuery($query);

        $resul = $search->search();
        return array_reduce(
            $resul->getAggregation($aggDateName)['buckets'],
            function ($byDate, $groupDate) use ($aggTypeName) {
                $byDate[$groupDate['key_as_string']] = array_column(
                    $groupDate[$aggTypeName]['buckets'],
                    'doc_count',
                    'key'
                );
                return $byDate;
            },
            []
        );
    }

    public function getAddedInLastDays(int $days, string $idClient): array
    {
        $dateStart = new \DateTimeImmutable('-' . $days . ' days');
        $query = new Query;
        $query->setSize(0);
        $bool = $this->boolRangeAndClient($dateStart, new \DateTimeImmutable(), $idClient);
        $bool->addMust(new Term(['type' => ActionType::productAdded()->type()]));
        $query->setQuery($bool);

        $aggDateName = "date_range_agg";
        $dateHist = new DateHistogram($aggDateName, 'date', 'day');
        $dateHist->setFormat('dd-MM-yyyy');
        $query->addAggregation($dateHist);

        $search = new Search($this->elasticClient);
        $search->addIndices([self::INDEX_NAME]);
        $search->setQuery($query);

        $resul = $search->search();
        return array_column(
            $resul->getAggregation($aggDateName)['buckets'],
            'doc_count',
            'key_as_string'
        );
    }

    public function findEvents(
        ?ActionType $type,
        \DateTimeImmutable $dateStart,
        \DateTimeImmutable $dateEnd,
        string $from,
        SortActions $sort,
        FilterActions $filter,
        string $idClient
    ): FindEventsOut {
        $query = new Query;
        $query->setSize(20);
        $query->setSort(['date' => 'asc']);
        $query->setFrom($from);
        $query->setSort([$sort->key() => $sort->direction()]);
        $bool = $this->boolRangeAndClient($dateStart, $dateEnd, $idClient);
        if ($type !== null) {
            $bool->addMust(new Term(['type' => ($type->type())]));
        }
        if ($filter->user() != '') {
            $bool->addMust(new Term(['idUser' => $filter->user()]));
        }
        if ($filter->chat() != '') {
            $bool->addMust(new Prefix(['chatType.keyword' => $filter->chat()]));
        }
        if ($filter->description() != '') {
            $bool->addMust(new Prefix(['data.keyword' => $filter->description()]));
        }
        $query->setQuery($bool);

        $search = new Search($this->elasticClient);
        $search->addIndices([self::INDEX_NAME]);
        $search->setQuery($query);
        $result = $search->search();
        $list = array_reduce(
            $result->getResults(),
            function ($carry, Result $item) {
                $data = $item->getSource();
                $carry[] = [
                    'id' => $data['id'],
                    'date' => (new \DateTimeImmutable($data['date']))->format('d-m-Y H:i:s'),
                    'user' => $data['idUser'],
                    'chat' => $data['chatType'],
                    'type' => (new ActionType($data['type']))->prettyType(),
                    'data' => $data['data']
                ];
                return $carry;
            },
            []
        );

        return new FindEventsOut($list, $result->getTotalHits());
    }

    private function boolRangeAndClient(
        \DateTimeImmutable $dateStart,
        \DateTimeImmutable $dateEnd,
        string $idClient
    ): Query\BoolQuery {
        $bool = new Query\BoolQuery();
        $bool->addMust($this->mustRange($dateStart, $dateEnd));
        $bool->addMust(new Term(['idClient' => $idClient]));
        return $bool;
    }

    private function mustRange(\DateTimeImmutable $dateStart, \DateTimeImmutable $dateEnd): Query\Range
    {
        return new Query\Range('date', [
            'gte' => $dateStart->format('Y-m-d 00:00:00'),
            'lte' => $dateEnd->format('Y-m-d 23:59:59')
        ]);
    }
}
