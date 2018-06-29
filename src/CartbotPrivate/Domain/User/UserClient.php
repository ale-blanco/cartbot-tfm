<?php

namespace CartbotPrivate\Domain\User;

use Cartbot\Domain\Client\Client;

class UserClient
{
    protected $id;
    protected $client;
    protected $username;
    protected $password;
    protected $email;
    protected $isActive;

    public function __construct(
        Client $client,
        string $userName,
        Email $email,
        bool $active
    ) {
        if (mb_strlen($userName, 'UTF-8') < 5) {
            throw new UserNameNotValidException();
        }

        $this->client = $client;
        $this->username = $userName;
        $this->email = $email->email();
        $this->isActive = $active ? 's' : 'n';
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function id(): ?string
    {
        return $this->id;
    }

    public function client(): Client
    {
        return $this->client;
    }

    public function username(): string
    {
        return $this->username;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function password(): ?string
    {
        return $this->password;
    }

    public function email(): Email
    {
        return new Email($this->email);
    }

    public function isActive(): bool
    {
        return ($this->isActive === 's');
    }
}
