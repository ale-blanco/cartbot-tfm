<?php

namespace CartbotPrivate\Infrastructure\Repository;

use CartbotPrivate\Domain\User\UserClient;
use CartbotPrivate\Domain\User\UserClientRepository;

class MemoryUserClientRepository implements UserClientRepository
{
    private $list = [];

    public function findOneByUserName(string $userName): ?UserClient
    {
        $item = null;
        foreach ($this->list as $userC) {
            if ($userC->username() === $userName) {
                return $userC;
            }
        }

        return null;
    }

    public function save(UserClient $userClient): void
    {
        $this->list[] = $userClient;
    }

    public function setList(array $list): void
    {
        $this->list = $list;
    }
}
