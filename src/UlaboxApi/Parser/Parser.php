<?php

namespace UlaboxApi\Parser;

interface Parser
{
    public static function parse(string $response);
}