<?php

namespace CartbotUnit\Domain\Product;

use PHPUnit\Framework\TestCase;
use Cartbot\Domain\Product\Product;

class ProductTest extends TestCase
{
    public function testShouldGiveMeOriginalData()
    {
        $id = '1';
        $name = 'thename';
        $description = 'the description';
        $price = '12,99';
        $product = new Product($id, $name, $description, $price);
        $this->assertEquals($id, $product->id());
        $this->assertEquals($name, $product->name());
        $this->assertEquals($description, $product->description());
        $this->assertEquals($price, $product->price());
    }
}
