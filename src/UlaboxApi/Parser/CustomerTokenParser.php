<?php

namespace UlaboxApi\Parser;

class CustomerTokenParser implements Parser
{
    public static function parse(string $response): string
    {
        $jsonObject = json_decode($response, true);
        if (!isset($jsonObject['data'])) {
            throw new \Exception('Not data key in response');
        }

        if (!array_key_exists('customer_token', $jsonObject['data'])) {
            throw new \Exception('Not customer_token key in response');
        }

        return $jsonObject['data']['customer_token'];
    }
}
