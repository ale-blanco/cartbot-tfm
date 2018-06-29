<?php

namespace CartbotUnit\Domain\Product;

use PHPUnit\Framework\TestCase;
use Cartbot\Domain\Product\ProductQuantity;

class ProductQuantityTest extends TestCase
{
    public function testShouldGiveMeOriginalQuantity()
    {
        $quantity = 44;
        $productQ = new ProductQuantity('1', 'thename', 'the description', '11,99', $quantity);
        $this->assertEquals($quantity, $productQ->quantity());
    }
}
