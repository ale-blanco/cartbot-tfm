<?php

namespace CartbotPrivate\Domain\Action;

use DomainException;

class IndexAlreadyCreatedException extends DomainException
{
    public function __construct()
    {
        parent::__construct('Indice ya creado');
    }
}
