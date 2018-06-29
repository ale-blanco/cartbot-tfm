<?php

namespace UlaboxApi\Models;

class Product
{
    private $type;
    private $id;
    private $attributes;

    public function __construct(string $type, string $id, Attributes $attributes)
    {
        $this->type = $type;
        $this->id = $id;
        $this->attributes = $attributes;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function attributes(): Attributes
    {
        return $this->attributes;
    }
}
