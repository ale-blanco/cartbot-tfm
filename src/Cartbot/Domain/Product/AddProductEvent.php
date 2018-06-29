<?php

namespace Cartbot\Domain\Product;

use Cartbot\Domain\Chat\ChatType;

class AddProductEvent
{
    private $userChatId;
    private $userChatType;
    private $userId;
    private $clientId;
    private $productName;

    public function __construct(
        string $userChatId,
        ChatType $userChatType,
        string $userId,
        String $clientId,
        string $productName
    ) {
        $this->userChatId = $userChatId;
        $this->userChatType = $userChatType;
        $this->userId = $userId;
        $this->clientId = $clientId;
        $this->productName = $productName;
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

    public function productName(): string
    {
        return $this->productName;
    }
}
