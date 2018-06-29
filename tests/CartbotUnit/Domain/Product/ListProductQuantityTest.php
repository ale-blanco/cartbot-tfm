<?php

namespace CartbotUnit\Domain\Product;

use PHPUnit\Framework\TestCase;
use Cartbot\Domain\Product\ListProductQuantity;

class ListProductQuantityTest extends TestCase
{
    public function testShouldGiveAEmptyArrayIfNull()
    {
        $this->assertEquals([], (new ListProductQuantity())->getAll());
    }

    public function testShouldThrownExceptionIfArrayContainNotProductQuantity()
    {
        $this->expectException(\Exception::class);
        new ListProductQuantity(['sldkaj']);
    }
}
