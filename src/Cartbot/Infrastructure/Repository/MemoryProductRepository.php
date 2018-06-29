<?php

namespace Cartbot\Infrastructure\Repository;

use Cartbot\Domain\Product\ListProduct;
use Cartbot\Domain\Product\ProductRepository;

class MemoryProductRepository implements ProductRepository
{
    private $resultSearch;

    public function __construct()
    {
        $this->resultSearch = new ListProduct();
    }

    public function searchProduct(string $queryProduct): ListProduct
    {
        return $this->resultSearch;
    }

    public function setResulSearch(ListProduct $result): void
    {
        $this->resultSearch = $result;
    }
}
