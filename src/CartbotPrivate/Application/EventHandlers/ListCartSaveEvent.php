<?php

namespace CartbotPrivate\Application\EventHandlers;

use CartbotPrivate\Domain\Action\Action;
use CartbotPrivate\Domain\Action\ActionType;
use Cartbot\Domain\Cart\ListCartEvent;

class ListCartSaveEvent extends AbstractSaveEvent
{
    public function __invoke(ListCartEvent $event): void
    {
        $action = new Action(
            new \DateTimeImmutable(),
            $event->clientId(),
            $event->userId(),
            $event->userChatType(),
            ActionType::cartListed(),
            ''
        );
        $this->actionRepository->saveAction($action);
    }
}
