<?php

namespace UlaboxApi\Actions\Carts;

use UlaboxApi\Actions\Action;
use UlaboxApi\Http\Method;
use UlaboxApi\Models\Cart;
use UlaboxApi\Parser\CartParser;

class Carts implements Action
{
    private $customerToken;

    public function __construct(string $customerToken)
    {
        $this->customerToken = $customerToken;
    }

    public function getMethod(): Method
    {
        return new Method(Method::HTTP_GET);
    }

    public function getUrl(): string
    {
        return 'carts';
    }

    public function getQueryData(): array
    {
        return ['customer_token' => $this->customerToken];
    }

    public function getPostData(): array
    {
        return [];
    }

    public function parseResult(string $response): Cart
    {
        return CartParser::parse($response);
    }
}
