<?php

namespace Cartbot\Domain\Chat;

interface ISenderChatFactory
{
    public function getSender(ChatType $chatType): SenderChatResponse;
}
