<?php

namespace Cartbot\Domain\Cart;

use Cartbot\Domain\Chat\ChatType;

class ListCartEvent
{
    private $userChatId;
    private $userChatType;
    private $userId;
    private $clientId;
    private $cart;

    public function __construct(
        string $userChatId,
        ChatType $userChatType,
        string $userId,
        String $clientId,
        Cart $cart
    ) {
        $this->userChatId = $userChatId;
        $this->userChatType = $userChatType;
        $this->userId = $userId;
        $this->clientId = $clientId;
        $this->cart = $cart;
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

    public function cart(): Cart
    {
        return $this->cart;
    }
}
