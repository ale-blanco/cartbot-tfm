<?php

namespace Cartbot\Domain\Product;

class Product
{
    private $id;
    private $name;
    private $description;
    private $price;

    public function __construct(string $id, string $name, string $description, string $price)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function price(): string
    {
        return $this->price;
    }
}
