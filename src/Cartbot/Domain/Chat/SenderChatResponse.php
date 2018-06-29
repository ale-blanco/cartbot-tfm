<?php

namespace Cartbot\Domain\Chat;

interface SenderChatResponse
{
    public function send(string $chatId, string $response): void;
}
