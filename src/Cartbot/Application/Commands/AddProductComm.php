<?php

namespace Cartbot\Application\Commands;

use Cartbot\Domain\Chat\ChatType;

class AddProductComm extends AbstractUserComm
{
    private $queryProduct;

    public function __construct(string $idUserInChat, ChatType $chatType, string $queryProduct)
    {
        parent::__construct($idUserInChat, $chatType);
        $this->queryProduct = $queryProduct;
    }

    public function queryProduct(): string
    {
        return $this->queryProduct;
    }
}
