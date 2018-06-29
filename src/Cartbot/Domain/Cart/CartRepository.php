<?php

namespace Cartbot\Domain\Cart;

use Cartbot\Domain\Product\Product;
use Cartbot\Domain\User\CustomerToken;

interface CartRepository
{
    public function listCart(CustomerToken $customerToken): Cart;
    public function addProduct(Product $product, CustomerToken $customerToken, int $quantity): int;
}
