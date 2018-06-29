<?php

namespace CartbotPrivate\Application\CommandHandlers\Admin;

use CartbotPrivate\Application\Outputs\Admin\FindEventsOut;
use CartbotPrivate\Domain\Action\ActionRepository;
use CartbotPrivate\Domain\Action\ActionType;
use CartbotPrivate\Domain\Action\FilterActions;
use CartbotPrivate\Domain\Action\SortActions;
use CartbotPrivate\Domain\ValidateException;

class FindEvents
{
    public const TYPE_ALL = 'all';
    public const ITEMS_BY_PAGE = 20;

    private $actionRepository;

    public function __construct(ActionRepository $actionRepository)
    {
        $this->actionRepository = $actionRepository;
    }

    public function __invoke(
        string $type,
        string $dateStart,
        string $dateEnd,
        string $page,
        string $order,
        FilterActions $filter,
        string $idClient
    ): FindEventsOut {
        $typeVO = $this->validateType($type);
        $start = $this->validateDate($dateStart, 'dateStart');
        $end = $this->validateDate($dateEnd, 'dateEnd');
        $this->validatePage($page);
        $from = ($page - 1) * self::ITEMS_BY_PAGE;

        return $this->actionRepository->findEvents(
            $typeVO,
            $start,
            $end,
            $from,
            new SortActions($order),
            $filter,
            $idClient
        );
    }

    private function validateType(string $type): ?ActionType
    {
        if (!in_array($type, array_merge(ActionType::allTypesString(), [self::TYPE_ALL]))) {
            throw new ValidateException('type', 'Valor no valido');
        }

        if ($type === self::TYPE_ALL) {
            return null;
        }

        return new ActionType($type);
    }

    private function validateDate(string $date, string $key): \DateTimeImmutable
    {
        $object = \DateTimeImmutable::createFromFormat('d/m/Y', $date);
        if ($object === false) {
            throw new ValidateException($key, 'Valor no valido');
        }

        return $object;
    }

    private function validatePage(string $page): void
    {
        if (!filter_var($page, FILTER_VALIDATE_INT) || $page < 1) {
            throw new ValidateException('page', 'Valor no valido');
        }
    }
}
