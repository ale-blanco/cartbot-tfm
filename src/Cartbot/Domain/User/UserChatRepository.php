<?php

namespace Cartbot\Domain\User;

use Cartbot\Domain\Chat\ChatType;

interface UserChatRepository
{
    public function getUserFromUserChatOrException(string $idUserInChat, ChatType $chatType): UserChat;
    public function saveUserChat(UserChat $userChat): void;
}
