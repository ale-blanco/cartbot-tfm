<?php

namespace Cartbot\Domain\User;

use Cartbot\Domain\Chat\ChatType;

class AuthorizeCorrectEvent
{
    private $userChatId;
    private $userChatType;
    private $userId;
    private $clientId;

    public function __construct(string $userChatId, ChatType $userChatType, string $userId, String $clientId)
    {
        $this->userChatId = $userChatId;
        $this->userChatType = $userChatType;
        $this->userId = $userId;
        $this->clientId = $clientId;
    }

    public function userChatId(): string
    {
        return $this->userChatId;
    }

    public function userChatType(): ChatType
    {
        return $this->userChatType;
    }

    public function userId(): string
    {
        return $this->userId;
    }

    public function clientId(): String
    {
        return $this->clientId;
    }
}
