<?php

namespace Cartbot\Infrastructure\Services\Assistant;

use Cartbot\Domain\Chat\SenderChatResponse;
use Symfony\Component\HttpFoundation\Session\Session;

class SendResponse implements SenderChatResponse
{
    public function send(string $chatId, string $response): void
    {
        $session = new Session();
        $session->getFlashBag()->add('response', $response);
    }
}
