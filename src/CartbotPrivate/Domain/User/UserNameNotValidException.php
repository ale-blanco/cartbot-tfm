<?php

namespace CartbotPrivate\Domain\User;

use Cartbot\Domain\DomainException;

class UserNameNotValidException extends DomainException
{
    public function __construct()
    {
        parent::__construct('Nombre de usuario no valido, minimo 5 caracteres');
    }
}
