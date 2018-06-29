<?php

namespace Cartbot\Infrastructure\Services;

use Cartbot\Domain\Chat\ChatType;
use Cartbot\Domain\Chat\ISenderChatFactory;
use Cartbot\Domain\Chat\SenderChatResponse;
use Cartbot\Infrastructure\Services\Telegram\SendResponse as TelegramSend;
use Cartbot\Infrastructure\Services\Assistant\SendResponse as AssistantSend;

class SenderChatFactory implements ISenderChatFactory
{
    private $telegramSender;
    private $assistantSender;

    public function __construct(TelegramSend $telegramSender, AssistantSend $assistantSender)
    {
        $this->telegramSender = $telegramSender;
        $this->assistantSender = $assistantSender;
    }

    public function getSender(ChatType $chatType): SenderChatResponse
    {
        if ($chatType->isEqual(ChatType::createTelegam())) {
            return $this->telegramSender;
        } elseif ($chatType->isEqual(ChatType::createAssistant())) {
            return $this->assistantSender;
        } else {
            throw new \Exception('Chat desconocido');
        }
    }
}
