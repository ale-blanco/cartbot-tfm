<?php

namespace CartbotPrivate\Application\EventHandlers;

use CartbotPrivate\Domain\Action\Action;
use CartbotPrivate\Domain\Action\ActionType;
use Cartbot\Domain\Product\AddProductEvent;

class AddProductSaveEvent extends AbstractSaveEvent
{
    public function __invoke(AddProductEvent $event): void
    {
        $action = new Action(
            new \DateTimeImmutable(),
            $event->clientId(),
            $event->userId(),
            $event->userChatType(),
            ActionType::productAdded(),
            $event->productName()
        );
        $this->actionRepository->saveAction($action);
    }
}
