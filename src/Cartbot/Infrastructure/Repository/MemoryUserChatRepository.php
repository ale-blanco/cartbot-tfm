<?php

namespace Cartbot\Infrastructure\Repository;

use Cartbot\Domain\Chat\ChatType;
use Cartbot\Domain\Client\Client;
use Cartbot\Domain\User\CustomerToken;
use Cartbot\Domain\User\User;
use Cartbot\Domain\User\UserChat;
use Cartbot\Domain\User\UserChatNotRegisteredException;
use Cartbot\Domain\User\UserChatRepository;

class MemoryUserChatRepository implements UserChatRepository
{
    private $list = [];
    private $saved = 0;

    public function getUserFromUserChatOrException(string $idUserInChat, ChatType $chatType): UserChat
    {
        if ($idUserInChat === '1') {
            $user = new User(
                '1',
                'user',
                new CustomerToken('1', new \DateTimeImmutable()),
                new Client('1', 'client', '', '')
            );
            return new UserChat('1', ChatType::createTelegam(), $user);
        } elseif ($idUserInChat === '2') {
            $token = new CustomerToken('2', new \DateTimeImmutable('-20 days'));
            $user = new User('2', 'user', $token, new Client('1', 'client', '', ''));
            return new UserChat('1', ChatType::createTelegam(), $user);
        }

        throw new UserChatNotRegisteredException();
    }

    public function numberSaved(): int
    {
        return $this->saved;
    }

    public function saveUserChat(UserChat $userChat): void
    {
        $this->saved++;
        $this->list[] = $userChat;
    }
}
