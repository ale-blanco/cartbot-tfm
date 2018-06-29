<?php

namespace Cartbot\Application\EventHandlers;

use Cartbot\Application\Services\TextListCommands;
use Cartbot\Domain\User\NotUnderstoodEvent;

class NotUnderstoodResponse extends AbstractResponse
{
    public function __invoke(NotUnderstoodEvent $event): void
    {
        $this->senderFactory
            ->getSender($event->userChatType())
            ->send($event->userChatId(), $this->getText());
    }

    private function getText(): string
    {
        return 'Lo siento, no he entendio, ¿puedes repetir?' . PHP_EOL
            . TextListCommands::getTextListCommands();
    }
}
