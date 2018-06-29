<?php

namespace CartbotPrivate\Domain\User;

use Cartbot\Domain\DomainException;

class PasswordNotValidException extends DomainException
{
    public function __construct()
    {
        parent::__construct('Contraseña no valida, entre 6 y 30 caracteres y al menos una letra y un numero');
    }
}
