<?php

namespace Cartbot\Infrastructure\Repository;

use Cartbot\Domain\Cart\Cart;
use Cartbot\Domain\Cart\CartRepository;
use Cartbot\Domain\Product\ListProductQuantity;
use Cartbot\Domain\Product\Product;
use Cartbot\Domain\Product\ProductQuantity;
use Cartbot\Domain\User\CustomerToken;
use UlaboxApi\Actions\Carts\AddProduct;
use UlaboxApi\Actions\Carts\Carts;
use UlaboxApi\Sender;

class UlaboxCartRepository implements CartRepository
{
    private $sender;

    public function __construct(Sender $sender)
    {
        $this->sender = $sender;
    }

    public function listCart(CustomerToken $customerToken): Cart
    {
        $resul = $this->sender->send(new Carts($customerToken->token()));
        if (count($resul->products()) === 0) {
            return new Cart(new ListProductQuantity(), $resul->total());
        }

        $listProductsQuantity = [];
        foreach ($resul->products() as $product) {
            $attr = $product->product()->attributes();
            $listProductsQuantity[] = new ProductQuantity(
                $product->product()->id(),
                $attr->name(),
                $attr->description(),
                $attr->price(),
                $product->quantity()
            );
        }

        return new Cart(new ListProductQuantity($listProductsQuantity), $resul->total());
    }

    public function addProduct(Product $product, CustomerToken $customerToken, int $quantity): int
    {
        $resul = $this->sender->send(new AddProduct(0, $product->id(), $quantity, $customerToken->token()));
        return $resul->totalPoducts();
    }
}
