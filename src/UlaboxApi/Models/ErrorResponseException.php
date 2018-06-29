<?php

namespace UlaboxApi\Models;

class ErrorResponseException extends \Exception
{
    private $key;

    public function __construct(int $code, string $key, string $literal)
    {
        parent::__construct($literal, $code);
        $this->key = $key;
    }

    public function key(): string
    {
        return $this->key;
    }
}
