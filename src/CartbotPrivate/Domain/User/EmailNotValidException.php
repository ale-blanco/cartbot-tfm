<?php

namespace CartbotPrivate\Domain\User;

use Cartbot\Domain\DomainException;

class EmailNotValidException extends DomainException
{
    public function __construct()
    {
        parent::__construct('Email not valid');
    }
}
