<?php

namespace UlaboxApi\Parser;

use UlaboxApi\Models\ErrorResponseException;

class ErrorParser implements Parser
{
    public static function parse(string $response): void
    {
        $jsonObject = json_decode($response, true);
        if (!isset($jsonObject['error'])) {
            throw new \Exception('Not error data in response');
        }

        $dataError = $jsonObject['error'];
        throw new ErrorResponseException($dataError['code'], $dataError['key'], $dataError['literal']);
    }
}
