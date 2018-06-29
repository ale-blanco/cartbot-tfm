<?php

namespace Cartbot\Application\EventHandlers;

use Cartbot\Application\Services\TextListCommands;
use Cartbot\Domain\User\AuthorizeCorrectEvent;

class AuthorizeCorrectResponse extends AbstractResponse
{
    public function __invoke(AuthorizeCorrectEvent $event): void
    {
        $this->senderFactory
            ->getSender($event->userChatType())
            ->send($event->userChatId(), $this->getText());
    }

    private function getText(): string
    {
        return 'Autorizacion realizada correctamente' . PHP_EOL
            . TextListCommands::getTextListCommands();
    }
}
