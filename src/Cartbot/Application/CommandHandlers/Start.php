<?php

namespace Cartbot\Application\CommandHandlers;

use SimpleBus\SymfonyBridge\Bus\EventBus;
use Cartbot\Application\Commands\StartComm;
use Cartbot\Domain\User\StartEvent;

class Start
{
    private $eventBus;

    public function __construct(EventBus $eventBus)
    {
        $this->eventBus = $eventBus;
    }

    public function __invoke(StartComm $startComm): void
    {
        $this->eventBus->handle(
            new StartEvent($startComm->idUserInChat(), $startComm->chatType(), $startComm->idClient())
        );
    }
}
