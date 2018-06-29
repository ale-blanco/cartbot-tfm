<?php

namespace Cartbot\Application\CommandHandlers;

use Cartbot\Application\Commands\NotUnderstoodComm;
use Cartbot\Application\Services\IUserService;
use Cartbot\Domain\Services\EventBus;
use Cartbot\Domain\User\NotUnderstoodEvent;

class NotUnderstood
{
    private $userService;
    private $eventBus;

    public function __construct(IUserService $userService, EventBus $eventBus)
    {
        $this->userService = $userService;
        $this->eventBus = $eventBus;
    }

    public function __invoke(NotUnderstoodComm $command): void
    {
        $userChat = $this->userService->getUserWithValidToken($command->idUserInChat(), $command->chatType());
        $this->eventBus->handle(new NotUnderstoodEvent(
            $userChat->id(),
            $userChat->type(),
            $userChat->user()->id(),
            $userChat->user()->client()->id()
        ));
    }
}
