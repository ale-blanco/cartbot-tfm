<?php

namespace CartbotPrivate\Application\EventHandlers;

use Cartbot\Domain\User\AuthorizeCorrectEvent;
use CartbotPrivate\Domain\Action\Action;
use CartbotPrivate\Domain\Action\ActionType;

class AuthorizeCorrectSaveEvent extends AbstractSaveEvent
{
    public function __invoke(AuthorizeCorrectEvent $event): void
    {
        $action = new Action(
            new \DateTimeImmutable(),
            $event->clientId(),
            $event->userId(),
            $event->userChatType(),
            ActionType::authorizeCorrect(),
            ''
        );
        $this->actionRepository->saveAction($action);
    }
}
