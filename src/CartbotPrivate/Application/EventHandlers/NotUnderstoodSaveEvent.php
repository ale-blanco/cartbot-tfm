<?php

namespace CartbotPrivate\Application\EventHandlers;

use CartbotPrivate\Domain\Action\Action;
use CartbotPrivate\Domain\Action\ActionType;
use Cartbot\Domain\User\NotUnderstoodEvent;

class NotUnderstoodSaveEvent extends AbstractSaveEvent
{
    public function __invoke(NotUnderstoodEvent $event): void
    {
        $action = new Action(
            new \DateTimeImmutable(),
            $event->clientId(),
            $event->userId(),
            $event->userChatType(),
            ActionType::notUnderstood(),
            ''
        );
        $this->actionRepository->saveAction($action);
    }
}
