<?php

namespace Cartbot\Application\Services;

use Cartbot\Domain\Chat\ChatType;
use Cartbot\Domain\Client\Client;
use Cartbot\Domain\User\CustomerToken;
use Cartbot\Domain\User\User;
use Cartbot\Domain\User\UserChat;

class FakeUserService implements IUserService
{
    public function getUserWithValidToken(string $idUserInChat, ChatType $chatType): UserChat
    {
        $client = new Client('1', 'client', '', '');
        $token = new CustomerToken('', new \DateTimeImmutable());
        $user = new User('1', 'user', $token, $client);
        return new UserChat('1', $chatType, $user);
    }
}
