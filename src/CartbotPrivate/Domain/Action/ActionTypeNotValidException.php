<?php

namespace CartbotPrivate\Domain\Action;

use DomainException;

class ActionTypeNotValidException extends DomainException
{
    public function __construct()
    {
        parent::__construct('Tipo de accion no valida');
    }
}
