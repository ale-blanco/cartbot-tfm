<?php

namespace Cartbot\Domain\Client;

use Cartbot\Domain\DomainException;

class ClientNotExistException extends DomainException
{
    public function __construct()
    {
        parent::__construct('No existe ningun cliente con ese id');
    }
}
