<?php

namespace CartbotPrivate\Domain\Action;

use Cartbot\Domain\Chat\ChatType;

class Action
{
    private $id;
    private $date;
    private $idClient;
    private $idUser;
    private $chatType;
    private $type;
    private $data;

    public function __construct(
        \DateTimeImmutable $date,
        string $idClient,
        string $idUser,
        ChatType $chatType,
        ActionType $type,
        string $data
    ) {
        $this->id = bin2hex(random_bytes(16));
        $this->date = $date;
        $this->idClient = $idClient;
        $this->idUser = $idUser;
        $this->chatType = $chatType;
        $this->type = $type;
        $this->data = $data;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'date' => $this->date->format('Y-m-d H:i:s'),
            'idClient' => $this->idClient,
            'idUser' => $this->idUser,
            'chatType' => $this->chatType->name(),
            'type' => $this->type->type(),
            'data' => $this->data
        ];
    }
}
