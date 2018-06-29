<?php

namespace UlaboxApi\Actions\Carts;

use UlaboxApi\Actions\Action;
use UlaboxApi\Http\Method;
use UlaboxApi\Models\CompactCartResponse;
use UlaboxApi\Parser\CompactCartParser;

class AddProduct implements Action
{
    private $customerToken;
    private $cartId;
    private $productId;
    private $quantity;

    public function __construct(string $cartId, string $productId, int $quantity, string $customerToken)
    {
        $this->customerToken = $customerToken;
        $this->cartId = $cartId;
        $this->productId = $productId;
        $this->quantity = $quantity;
    }

    public function getMethod(): Method
    {
        return new Method(Method::HTTP_POST);
    }

    public function getUrl(): string
    {
        return 'carts/products';
    }

    public function getQueryData(): array
    {
        return ['customer_token' => $this->customerToken];
    }

    public function getPostData(): array
    {
        return [
            'data' => [
                'type' => 'cart',
                'id' => $this->cartId,
                'attributes' => [
                    'product_id' => $this->productId,
                    'quantity' => $this->quantity
                ]
            ]
        ];
    }

    public function parseResult(string $response): CompactCartResponse
    {
        return CompactCartParser::parse($response);
    }
}
