<?php

namespace Cartbot\Application\EventHandlers;

use Cartbot\Domain\Cart\ListCartEvent;

class ListCartResponse extends AbstractResponse
{
    public function __invoke(ListCartEvent $event): void
    {
        $response = '';
        foreach ($event->cart()->getAll() as $productQuantity) {
            $response .= $productQuantity->quantity() . ' de ' . $productQuantity->name() . PHP_EOL;
        }
        $response .= 'TOTAL: ' . $event->cart()->totalPrice();
        $this->senderFactory
            ->getSender($event->userChatType())
            ->send($event->userChatId(), $response);
    }
}
