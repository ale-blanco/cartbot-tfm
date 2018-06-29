<?php

namespace UlaboxApi\Parser;

use UlaboxApi\Models\Attributes;
use UlaboxApi\Models\Cart;
use UlaboxApi\Models\ListProductsQuantity;
use UlaboxApi\Models\Product;
use UlaboxApi\Models\ProductQuantity;

class CartParser implements Parser
{
    private const TYPE = 'cart';

    public static function parse(string $response): Cart
    {
        $jsonObject = json_decode($response, true);
        if (!isset($jsonObject['data'])) {
            throw new \Exception('Not data key in response');
        }

        $data = $jsonObject['data'];
        if (!array_key_exists('type', $data) || $data['type'] != self::TYPE) {
            throw new \Exception('Not valid type');
        }

        $attributes = $data['attributes'];
        $quantityFromIds = [];
        foreach ($attributes['ids'] as $id => $quantity) {
            $quantityFromIds[$id] = $quantity;
        }

        $products = ProductsKeyParser::parse($attributes);
        $arrayProductsQuantity = [];
        foreach ($products as $item) {
            $arrayProductsQuantity[] = new ProductQuantity($item, $quantityFromIds[$item->id()]);
        }

        return new Cart(
            new ListProductsQuantity(...$arrayProductsQuantity),
            $attributes['total']
        );
    }
}
