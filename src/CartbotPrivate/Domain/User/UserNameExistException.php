<?php

namespace CartbotPrivate\Domain\User;

use Cartbot\Domain\DomainException;

class UserNameExistException extends DomainException
{
    public function __construct()
    {
        parent::__construct('Ya existe un usuario cliente con ese nombre de usuario');
    }
}
