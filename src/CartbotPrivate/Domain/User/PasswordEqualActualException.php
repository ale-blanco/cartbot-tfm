<?php

namespace CartbotPrivate\Domain\User;

use Cartbot\Domain\DomainException;

class PasswordEqualActualException extends DomainException
{
    public function __construct()
    {
        parent::__construct('La nueva contraseña debe ser distinta a la actual');
    }
}
