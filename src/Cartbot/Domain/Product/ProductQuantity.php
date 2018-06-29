<?php

namespace Cartbot\Domain\Product;

class ProductQuantity extends Product
{
    private $quantity;

    public function __construct(string $id, string $name, string $description, string $price, int $quantity)
    {
        parent::__construct($id, $name, $description, $price);
        $this->quantity = $quantity;
    }

    public static function fromProduct(Product $product, int $quantity): self
    {
        return new self($product->id(), $product->name(), $product->description(), $product->price(), $quantity);
    }

    public function quantity(): int
    {
        return $this->quantity;
    }
}
