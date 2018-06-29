<?php

namespace CartbotPrivate\Domain\User;

interface UserClientRepository
{
    public function findOneByUserName(string $userName): ?UserClient;
    public function save(UserClient $userClient): void;
}