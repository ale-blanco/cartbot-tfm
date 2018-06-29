<?php

namespace Cartbot\Domain\User;

use Cartbot\Domain\Client\Client;

interface UserRepository
{
    public function getUserByNameAndClient(string $name, Client $client): ?User;
    public function saveUser(User $user): void;
}
