<?php

namespace UlaboxApi\Parser;

use UlaboxApi\Models\CompactCartResponse;

class CompactCartParser implements Parser
{
    private const TYPE = 'compact_cart';

    public static function parse(string $response): CompactCartResponse
    {
        $jsonObject = json_decode($response, true);
        if (!isset($jsonObject['data'])) {
            throw new \Exception('Not data key in response');
        }

        $data = $jsonObject['data'];
        if (!array_key_exists('type', $data) || $data['type'] != self::TYPE) {
            throw new \Exception('Not valid type');
        }


        if (!isset($data['attributes'])) {
            throw new \Exception('Not attributes key in response');
        }

        $attributes = $data['attributes'];
        return new CompactCartResponse($attributes['total'], $attributes['number_products']);
    }
}
