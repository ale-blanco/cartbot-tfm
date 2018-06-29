<?php

namespace UlaboxApi\Models;

class ProductsResponse
{
    private $products;

    public function __construct(Product... $products)
    {
        $this->products = $products;
    }

    public function products(): array
    {
        return $this->products;
    }
}
