<?php

namespace Cartbot\Infrastructure\Repository;

use Cartbot\Domain\Cart\Cart;
use Cartbot\Domain\Cart\CartRepository;
use Cartbot\Domain\Product\ListProductQuantity;
use Cartbot\Domain\Product\Product;
use Cartbot\Domain\Product\ProductQuantity;
use Cartbot\Domain\User\CustomerToken;

class MemoryCartRepository implements CartRepository
{
    private $cart;

    public function __construct()
    {
        $this->cart = new Cart(new ListProductQuantity(null), '0');
    }

    public function listCart(CustomerToken $customerToken): Cart
    {
        return $this->cart;
    }

    public function addProduct(Product $product, CustomerToken $customerToken, int $quantity): int
    {
        $new = ProductQuantity::fromProduct($product, $quantity);
        $list = $this->cart->getAll();
        $list[] = $new;
        $total = array_reduce($list, function (float $carry, ProductQuantity $item) {
            $carry += (float)$item->price();
            return $carry;
        }, 0);

        $this->cart = new Cart(new ListProductQuantity($list), (string)$total);
        return count($list);
    }
}
