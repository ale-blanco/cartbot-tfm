<?php

namespace Cartbot\Domain\Product;

class ListProductQuantity
{
    private $productsQuantity = [];

    public function __construct(?array $productsQuantity = null)
    {
        if ($productsQuantity === null || count($productsQuantity) === 0) {
            return;
        }

        foreach ($productsQuantity as $product) {
            if (!$product instanceof ProductQuantity) {
                throw new \Exception('Only object type Product');
            }
        }

        $this->productsQuantity = $productsQuantity;
    }

    public function get(int $index): ProductQuantity
    {
        return $this->productsQuantity[$index];
    }

    public function getAll(): array
    {
        return $this->productsQuantity;
    }

    public function count(): int
    {
        return count($this->productsQuantity);
    }
}
