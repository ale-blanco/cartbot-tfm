<?php

namespace Cartbot\Infrastructure\Services\Telegram;

use GuzzleHttp\Client;
use Cartbot\Domain\Chat\SenderChatResponse;

class SendResponse implements SenderChatResponse
{
    private $tokenTelegram;
    private $client;

    public function __construct(string $tokenTelegram)
    {
        $this->tokenTelegram = $tokenTelegram;
        $this->client = new Client();
    }

    public function send(string $chatId, string $response): void
    {
        $this->client->request(
            'GET',
            'https://api.telegram.org/bot' . $this->tokenTelegram . '/sendmessage',
            [
                'http_errors' => false,
                'query' => ['chat_id' => $chatId, 'text' => $response]
            ]
        );
    }
}
