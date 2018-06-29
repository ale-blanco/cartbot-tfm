<?php

namespace CartbotPrivate\Infrastructure\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use CartbotPrivate\Domain\User\UserClient;

class SymfonyUserClient extends UserClient implements UserInterface
{
    private const ROLE = 'ROLE_ADMIN';

    public function __construct(UserClient $userClient)
    {
        parent::__construct(
            $userClient->client(),
            $userClient->username(),
            $userClient->email(),
            $userClient->isActive()
        );

        if ($userClient->id() !== null) {
            $this->setId($userClient->id());
        }

        if ($userClient->password() !== null) {
            $this->setPassword($userClient->password());
        }
    }

    public function getRoles()
    {
        return [self::ROLE];
    }

    public function getPassword()
    {
        return $this->password();
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername()
    {
        return $this->username();
    }

    public function eraseCredentials()
    {
    }
}
