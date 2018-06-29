<?php

namespace UlaboxApi\Models;

class Cart
{
    private $products;
    private $total;

    public function __construct(ListProductsQuantity $products, float $total)
    {
        $this->products = $products;
        $this->total = $total;
    }

    public function products(): array
    {
        return $this->products->products();
    }

    public function total(): float
    {
        return $this->total;
    }

    public function numberProducts(): int
    {
        return count($this->products->products());
    }
}
