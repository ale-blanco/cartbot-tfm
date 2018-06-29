<?php

namespace Cartbot\Domain\Client;

class Client
{
    private $id;
    private $name;
    private $urlAuth;
    private $idClientAuth;

    public function __construct(?string $id, string $name, string $urlAuth, string $idClientAuth)
    {
        $this->id = $id;
        $this->name = $name;
        $this->urlAuth = $urlAuth;
        $this->idClientAuth = $idClientAuth;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function urlAuth(): string
    {
        return $this->urlAuth;
    }

    public function idClientAuth(): string
    {
        return $this->idClientAuth;
    }
}
