<?php

namespace Cartbot\Application\EventHandlers;

use Cartbot\Domain\Product\AddProductEvent;

class AddProductResponse extends AbstractResponse
{
    public function __invoke(AddProductEvent $event): void
    {
        $this->senderFactory
            ->getSender($event->userChatType())
            ->send($event->userChatId(), 'Añadido 1 de ' . $event->productName());
    }
}
