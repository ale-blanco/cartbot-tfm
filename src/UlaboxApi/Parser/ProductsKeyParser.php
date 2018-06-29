<?php

namespace UlaboxApi\Parser;

use UlaboxApi\Models\Attributes;
use UlaboxApi\Models\Product;

class ProductsKeyParser
{
    public static function parse(array $products): array
    {
        $productsResp = [];
        foreach ($products['products'] as $item) {
            $attributes = new Attributes(
                $item['attributes']['name'],
                $item['attributes']['raw_description'],
                (float)$item['attributes']['price']
            );
            $productsResp[] = new Product($item['type'], $item['id'], $attributes);
        }

        return $productsResp;
    }
}
