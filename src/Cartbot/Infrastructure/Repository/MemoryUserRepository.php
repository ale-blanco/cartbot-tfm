<?php

namespace Cartbot\Infrastructure\Repository;

use Cartbot\Domain\Client\Client;
use Cartbot\Domain\User\User;
use Cartbot\Domain\User\UserRepository;

class MemoryUserRepository implements UserRepository
{
    private $list = [];
    private $saved = 0;

    public function getUserByNameAndClient(string $name, Client $client): ?User
    {
        if ($name === 'user' && $client->id() === '1') {
            return new User(
                '1',
                'user',
                new CustomerToken('1', new \DateTimeImmutable()),
                $client
            );
        }

        return null;
    }

    public function saveUser(User $user): void
    {
        $this->saved++;
        $this->list[] = $user;
    }

    public function numberSaved(): int
    {
        return $this->saved;
    }
}
