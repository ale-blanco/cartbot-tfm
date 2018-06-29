<?php

namespace Cartbot\Domain\User;

use Cartbot\Domain\DomainException;

class NotUserStartForCodeException extends DomainException
{
    public function __construct()
    {
        parent::__construct('Codigo no valido');
    }
}
