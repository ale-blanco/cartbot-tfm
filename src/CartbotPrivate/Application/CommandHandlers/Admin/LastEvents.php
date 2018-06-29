<?php

namespace CartbotPrivate\Application\CommandHandlers\Admin;

use CartbotPrivate\Application\Outputs\Admin\LastsEventsOut;
use CartbotPrivate\Domain\Action\ActionRepository;
use CartbotPrivate\Domain\Action\ActionType;

class LastEvents
{
    private $actionRepository;

    public function __construct(ActionRepository $actionRepository)
    {
        $this->actionRepository = $actionRepository;
    }

    public function __invoke(string $idClient): LastsEventsOut
    {
        $resul = $this->actionRepository->getLastEvents($idClient);
        $byType = $this->getTotalByType($resul);
        return new LastsEventsOut($byType, $this->prettifyType($resul), $this->getLabels());
    }

    private function getTotalByType(array $data): array
    {
        return array_reduce($data, function ($carry, $item) {
            foreach ($item as $type => $num) {
                $prettyType = (new ActionType($type))->prettyType();
                $carry[$prettyType] = (isset($carry[$prettyType])) ? $carry[$prettyType] + $num : $num;
            }
            return $carry;
        }, []);
    }

    private function prettifyType(array $list): array
    {
        return array_map(function (array $listHour) {
            $resul = [];
            foreach ($listHour as $key => $val) {
                $prettyKey = (new ActionType($key))->prettyType();
                $resul[$prettyKey] = $val;
            }
            return $resul;
        }, $list);
    }

    private function getLabels(): array
    {
        return ActionType::allPrettyTypesString();
    }
}
