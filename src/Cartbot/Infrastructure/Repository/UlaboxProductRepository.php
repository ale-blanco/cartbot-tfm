<?php

namespace Cartbot\Infrastructure\Repository;

use Cartbot\Domain\Product\ListProduct;
use Cartbot\Domain\Product\Product;
use Cartbot\Domain\Product\ProductRepository;
use UlaboxApi\Actions\Products\Search;
use UlaboxApi\Sender;

class UlaboxProductRepository implements ProductRepository
{
    private $sender;

    public function __construct(Sender $sender)
    {
        $this->sender = $sender;
    }

    public function searchProduct(string $queryProduct): ListProduct
    {
        $resul = $this->sender->send(new Search($queryProduct));
        $productos = $resul->products();
        if (count($productos) === 0) {
            return new ListProduct();
        }

        $listProducts = [];
        foreach ($productos as $product) {
            $attr = $product->attributes();
            $listProducts[] = new Product(
                $product->id(),
                $attr->name(),
                $attr->description(),
                $attr->price()
            );
        }

        return new ListProduct($listProducts);
    }
}
