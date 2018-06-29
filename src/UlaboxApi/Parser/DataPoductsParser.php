<?php

namespace UlaboxApi\Parser;

use UlaboxApi\Models\ProductsResponse;

class DataPoductsParser implements Parser
{
    public static function parse(string $response): ProductsResponse
    {
        $jsonObject = json_decode($response, true);
        if (!isset($jsonObject['data'])) {
            throw new \Exception('Not data key in response');
        }

        if (!array_key_exists('products', $jsonObject['data'])) {
            throw new \Exception('Not products key in response');
        }

        $products = ProductsKeyParser::parse($jsonObject['data']);
        return new ProductsResponse(...$products);
    }
}
