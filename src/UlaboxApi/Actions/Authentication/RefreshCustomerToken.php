<?php

namespace UlaboxApi\Actions\Authentication;

use UlaboxApi\Actions\Action;
use UlaboxApi\Http\Method;
use UlaboxApi\Parser\CustomerTokenParser;

class RefreshCustomerToken implements Action
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
        return 'auth/refresh-customer-token';
    }

    public function getQueryData(): array
    {
        return ['customer_token' => $this->customerToken];
    }

    public function getPostData(): array
    {
        return [];
    }

    public function parseResult(string $response)
    {
        return CustomerTokenParser::parse($response);
    }
}
