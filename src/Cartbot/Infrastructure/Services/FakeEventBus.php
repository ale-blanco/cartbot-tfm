<?php

namespace Cartbot\Infrastructure\Services;

use Cartbot\Domain\Services\EventBus;

class FakeEventBus implements EventBus
{
    private $eventsReceived = [];

    public function handle($event): void
    {
        $this->eventsReceived[] = $event;
    }

    public function hasEventOfType(string $class): bool
    {
        foreach ($this->eventsReceived as $event) {
            if (get_class($event) == $class) {
                return true;
            }
        }

        return false;
    }
}
