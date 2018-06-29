<?php

namespace Cartbot\Application\Commands;

use Cartbot\Domain\Chat\ChatType;

abstract class AbstractUserComm implements CommandInterface
{
    private $idUserInChat;
    private $chatType;

    public function __construct(string $idUserInChat, ChatType $chatType)
    {
        $this->idUserInChat = $idUserInChat;
        $this->chatType = $chatType;
    }

    public function idUserInChat(): string
    {
        return $this->idUserInChat;
    }

    public function chatType(): ChatType
    {
        return $this->chatType;
    }
}
