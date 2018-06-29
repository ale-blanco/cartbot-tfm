<?php

namespace CartbotUnit\Domain\Cart;

use PHPUnit\Framework\TestCase;
use Cartbot\Domain\Cart\Cart;
use Cartbot\Domain\Product\ListProductQuantity;

class CartTest extends TestCase
{
    public function testShouldGiveMeTotalPrice()
    {
        $total = '14,95';
        $cart = new Cart(new ListProductQuantity(), $total);
        $this->assertEquals($cart->totalPrice(), $total);
    }
}
