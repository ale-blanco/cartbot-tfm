<?php

namespace Cartbot\Application\Services;

use Cartbot\Domain\Chat\ChatType;
use Cartbot\Domain\User\UserChat;

interface IUserService
{
    public function getUserWithValidToken(string $idUserInChat, ChatType $chatType): UserChat;
}
