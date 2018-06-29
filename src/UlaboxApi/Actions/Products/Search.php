<?php

namespace UlaboxApi\Actions\Products;

use UlaboxApi\Actions\Action;
use UlaboxApi\Http\Method;
use UlaboxApi\Models\ProductsResponse;
use UlaboxApi\Parser\DataPoductsParser;

class Search implements Action
{
    private $searchCriteria;

    public function __construct(string $searchCriteria)
    {
        $this->searchCriteria = $searchCriteria;
    }

    public function getMethod(): Method
    {
        return new Method(Method::HTTP_GET);
    }

    public function getUrl(): string
    {
        return 'products/search';
    }

    public function getQueryData(): array
    {
        return ['q' => $this->searchCriteria, 'limit' => 10];
    }

    public function getPostData(): array
    {
        return [];
    }

    public function parseResult(string $response): ProductsResponse
    {
        return DataPoductsParser::parse($response);
    }
}
