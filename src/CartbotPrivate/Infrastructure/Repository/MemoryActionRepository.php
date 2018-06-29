<?php

namespace CartbotPrivate\Infrastructure\Repository;

use CartbotPrivate\Application\Outputs\Admin\FindEventsOut;
use CartbotPrivate\Domain\Action\Action;
use CartbotPrivate\Domain\Action\ActionRepository;
use CartbotPrivate\Domain\Action\ActionType;
use CartbotPrivate\Domain\Action\FilterActions;
use CartbotPrivate\Domain\Action\SortActions;

class MemoryActionRepository implements ActionRepository
{
    private $list = [];

    public function indexExist(): bool
    {
        return true;
    }

    public function createIndex(): void
    {
    }

    public function saveAction(Action $action): void
    {
        $this->list[] = $action;
    }

    public function getLastEvents(string $idClient): array
    {
        return [
            '0' => [
                'not_understood' => 7,
                'product_added' => 4,
                'cart_listed' => 3,
            ],
            '1' => [
                'not_understood' => 1,
                'product_added' => 1,
            ],
            '2' => [
                'product_added' => 8,
                'cart_listed' => 6,
                'not_understood' => 4,
            ],
            '3' => [
                'not_understood' => 3,
                'cart_listed' => 1,
                'product_added' => 1,
            ],
            '4' => [
                'cart_listed' => 1,
                'product_added' => 1,
            ],
            '5' => [
                'cart_listed' => 1,
            ],
            '6' => [
                'not_understood' => 13,
                'cart_listed' => 9,
            ],
            '7' => [
                'not_understood' => 8,
                'product_added' => 5,
            ],
            '8' => [
                'cart_listed' => 7,
                'product_added' => 1,
            ],
            '9' => [
                'not_understood' => 13,
                'cart_listed' => 6,
                'product_added' => 2,
            ],
            '10' => [
                'cart_listed' => 5,
                'product_added' => 5,
                'not_understood' => 1,
            ],
            '11' => [
                'not_understood' => 2,
                'product_added' => 2,
                'cart_listed' => 1,
            ],
            '12' => [
                'product_added' => 5,
                'cart_listed' => 3,
                'not_understood' => 2,
            ],
            '13' => [
                'cart_listed' => 4,
                'product_added' => 4,
                'not_understood' => 2,
            ],
            '14' => [
                'product_added' => 8,
                'cart_listed' => 5,
                'not_understood' => 2,
            ],
            '15' => [
                'cart_listed' => 4,
                'not_understood' => 2,
            ],
            '16' => [
                'product_added' => 2,
                'not_understood' => 1,
            ],
            '17' => [
                'not_understood' => 12,
                'product_added' => 11,
                'cart_listed' => 3,
            ],
            '18' => [
                'not_understood' => 14,
                'product_added' => 1,
            ],
            '19' => [
                'cart_listed' => 8,
                'not_understood' => 1,
                'product_added' => 1,
            ],
            '20' => [
                'product_added' => 16,
                'not_understood' => 14,
                'cart_listed' => 10,
            ],
            '21' => [
                'cart_listed' => 2,
                'product_added' => 2,
            ],
            '22' => [
            ],
            '23' => [
                'cart_listed' => 2,
                'not_understood' => 1,
                'product_added' => 1,
            ]
        ];
    }

    public function getAddedInLastDays(int $days, string $idClient): array
    {
        return [
            'dia-7' => 19,
            'dia-6' => 23,
            'dia-5' => 87,
            'dia-4' => 60,
            'dia-3' => 44,
            'dia-2' => 67,
            'dia-1' => 12,
            'dia0' => 90,
        ];
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
        return new FindEventsOut([], 0);
    }
}
