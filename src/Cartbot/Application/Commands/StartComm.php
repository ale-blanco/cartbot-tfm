<?php

namespace Cartbot\Application\Commands;

use Cartbot\Domain\Chat\ChatType;

class StartComm extends AbstractUserComm
{
    private $idClient;

    public function __construct(string $idUserInChat, ChatType $chatType, string $idClient)
    {
        parent::__construct($idUserInChat, $chatType);
        $this->idClient = $idClient;
    }

    public function idClient(): string
    {
        return $this->idClient;
    }
}
