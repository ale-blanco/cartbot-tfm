<?php

namespace Cartbot\Domain\Product;

class ListProduct implements \Countable
{
    private $products = [];

    public function __construct(?array $products = null)
    {
        if ($products === null || count($products) === 0) {
            return;
        }

        foreach ($products as $product) {
            if (!$product instanceof Product) {
                throw new \Exception('Only object type Product');
            }
        }

        $this->products = $products;
    }

    public function get(int $index): Product
    {
        return $this->products[$index];
    }

    public function getAll(): array
    {
        return $this->products;
    }

    public function count(): int
    {
        return count($this->products);
    }
}
