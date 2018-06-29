<?php

namespace Cartbot\Domain\Chat;

class MessageChat
{
    private $text;
    private $idUser;
    private $chatType;
    private $idClient;

    public function __construct(string $text, string $idUser, ChatType $chatType, string $idClient)
    {
        $this->text = $text;
        $this->idUser = $idUser;
        $this->chatType = $chatType;
        $this->idClient = $idClient;
    }

    public function text(): string
    {
        return $this->text;
    }

    public function idUser(): string
    {
        return $this->idUser;
    }

    public function chatType(): ChatType
    {
        return $this->chatType;
    }

    public function idClient(): string
    {
        return $this->idClient;
    }
}
