<?php

namespace Cartbot\Domain\User;

use Cartbot\Domain\Chat\ChatType;
use Cartbot\Domain\Client\Client;

class UserStart
{
    private $code;
    private $client;
    private $idUserChat;
    private $chatType;

    public function __construct(string $code, Client $client, string $idUserChat, ChatType $chatType)
    {
        $this->code = $code;
        $this->client = $client;
        $this->idUserChat = $idUserChat;
        $this->chatType = $chatType->name();
    }

    public function code(): string
    {
        return $this->code;
    }

    public function client(): Client
    {
        return $this->client;
    }

    public function idUserChat(): string
    {
        return $this->idUserChat;
    }

    public function chatType(): ChatType
    {
        return new ChatType($this->chatType);
    }
}
