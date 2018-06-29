<?php

namespace Cartbot\Domain\Client;

use Cartbot\Domain\DomainException;

class ClientNotConfigureException extends DomainException
{
    public function __construct()
    {
        parent::__construct('Cliente no configurado o idcliente no valido');
    }
}
