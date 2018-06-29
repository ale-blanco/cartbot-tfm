<?php

namespace Cartbot\Domain\Cart;

use Cartbot\Domain\Product\ListProduct;
use Cartbot\Domain\Product\ListProductQuantity;

class Cart extends ListProduct
{
    private $totalPrice;

    public function __construct(ListProductQuantity $products, string $totalPrice)
    {
        parent::__construct($products->getAll());
        $this->totalPrice = $totalPrice;
    }

    public function totalPrice(): string
    {
        return $this->totalPrice;
    }
}
