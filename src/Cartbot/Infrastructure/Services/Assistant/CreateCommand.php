<?php

namespace Cartbot\Infrastructure\Services\Assistant;

use Cartbot\Application\Commands\AddProductComm;
use Cartbot\Application\Commands\CommandInterface;
use Cartbot\Application\Commands\ListCartComm;
use Cartbot\Application\Commands\NotUnderstoodComm;
use Cartbot\Application\Commands\StartComm;
use Cartbot\Domain\Chat\MessageChat;

class CreateCommand
{
    public function create(MessageChat $messageChat): CommandInterface
    {
        $texto = strtolower($messageChat->text());
        if ($texto == 'input.welcome') {
            return $this->commandStart($messageChat);
        } elseif ($texto == 'show_cart') {
            return $this->commandListCart($messageChat);
        } elseif (preg_match('/^add_product /', $texto)) {
            return $this->commandAddProduct($messageChat);
        } else {
            return $this->commandNotUnderstood($messageChat);
        }
    }

    private function commandStart(MessageChat $messageChat): CommandInterface
    {
        return new StartComm($messageChat->idUser(), $messageChat->chatType(), $messageChat->idClient());
    }

    private function commandListCart(MessageChat $messageChat): CommandInterface
    {
        return new ListCartComm($messageChat->idUser(), $messageChat->chatType());
    }

    private function commandNotUnderstood(MessageChat $messageChat): CommandInterface
    {
        return new NotUnderstoodComm($messageChat->idUser(), $messageChat->chatType());
    }

    private function commandAddProduct(MessageChat $messageChat): CommandInterface
    {
        return new AddProductComm($messageChat->idUser(), $messageChat->chatType(), substr($messageChat->text(), 12));
    }
}
