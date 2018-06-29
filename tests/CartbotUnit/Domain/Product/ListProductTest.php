<?php

namespace CartbotUnit\Domain\Product;

use PHPUnit\Framework\TestCase;
use Cartbot\Domain\Product\ListProduct;

class ListProductTest extends TestCase
{
    public function testShouldGiveAEmptyArrayIfNull()
    {
        $this->assertEquals([], (new ListProduct())->getAll());
    }

    public function testShouldThrownExceptionIfArrayContainNotProduct()
    {
        $this->expectException(\Exception::class);
        new ListProduct(['sldkaj']);
    }
}
