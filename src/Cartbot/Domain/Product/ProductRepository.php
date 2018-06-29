<?php

namespace Cartbot\Domain\Product;

interface ProductRepository
{
    public function searchProduct(string $queryProduct): ListProduct;
}
