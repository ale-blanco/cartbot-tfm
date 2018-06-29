<?php

namespace CartbotPrivate\Domain\Action;

use CartbotPrivate\Application\Outputs\Admin\FindEventsOut;

interface ActionRepository
{
    public function indexExist(): bool;

    public function createIndex(): void;

    public function saveAction(Action $action): void;

    public function getLastEvents(string $idClient): array;

    public function getAddedInLastDays(int $days, string $idClient): array;

    public function findEvents(
        ?ActionType $type,
        \DateTimeImmutable $dateStart,
        \DateTimeImmutable $dateEnd,
        string $from,
        SortActions $sort,
        FilterActions $filter,
        string $idClient
    ): FindEventsOut;
}