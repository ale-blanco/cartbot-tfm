<?php

namespace UlaboxApi\Models;

class ListProductsQuantity
{
    private $poducts;

    public function __construct(ProductQuantity... $poducts)
    {
        $this->poducts = $poducts;
    }

    public function products(): array
    {
        return $this->poducts;
    }
}
