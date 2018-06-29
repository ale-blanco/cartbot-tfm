<?php

namespace CartbotPrivate\Domain;

use Cartbot\Domain\DomainException;

class ValidateException extends DomainException
{
    public function __construct(string $key, string $message)
    {
        parent::__construct(json_encode([$key => $message]));
    }
}
