<?php

namespace Cartbot\Domain\User;

use Cartbot\Domain\Chat\ChatType;

class StartEvent
{
    private $idUserChat;
    private $chatType;
    private $idClient;

    public function __construct(string $idUserChat, ChatType $chatType, string $idClient)
    {
        $this->idUserChat = $idUserChat;
        $this->chatType = $chatType;
        $this->idClient = $idClient;
    }

    public function idUserChat(): string
    {
        return $this->idUserChat;
    }

    public function chatType(): ChatType
    {
        return $this->chatType;
    }

    public function idClient(): string
    {
        return $this->idClient;
    }
}
