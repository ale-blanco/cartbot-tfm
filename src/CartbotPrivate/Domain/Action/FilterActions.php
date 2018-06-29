<?php

namespace CartbotPrivate\Domain\Action;

class FilterActions
{
    private $user;
    private $chat;
    private $description;

    public function __construct(string $user, string $chat, string $description)
    {
        $this->user = $user;
        $this->chat = $chat;
        $this->description = $description;
    }

    public function user(): string
    {
        return $this->user;
    }

    public function chat(): string
    {
        return $this->chat;
    }

    public function description(): string
    {
        return $this->description;
    }
}
