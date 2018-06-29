<?php

namespace Cartbot\Infrastructure\Services;

use Cartbot\Domain\Services\EventBus;
use SimpleBus\SymfonyBridge\Bus\EventBus as SimpleEventBus;

class SimpleBusEventBus implements EventBus
{
    private $eventBus;

    public function __construct(SimpleEventBus $eventBus)
    {
        $this->eventBus = $eventBus;
    }

    public function handle($event): void
    {
        $this->eventBus->handle($event);
    }
}
