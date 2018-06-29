<?php

namespace Cartbot\Domain\Chat;

use Cartbot\Domain\DomainException;

class ChatTypeNotValidException extends DomainException
{
    public function __construct()
    {
        parent::__construct('Tipo de chat no valido');
    }
}
