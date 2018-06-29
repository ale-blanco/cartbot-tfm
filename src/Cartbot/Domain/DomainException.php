<?php

namespace Cartbot\Domain;

class DomainException extends \Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
