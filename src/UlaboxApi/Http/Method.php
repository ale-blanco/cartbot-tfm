<?php

namespace UlaboxApi\Http;

class Method
{
    public const HTTP_GET = 'GET';
    public const HTTP_POST = 'POST';
    public const HTTP_PUT = 'PUT';
    public const HTTP_DELETE = 'DELETE';

    private $method;

    public function __construct(string $method)
    {
        if (!in_array($method, [self::HTTP_GET, self::HTTP_POST, self::HTTP_PUT, self::HTTP_DELETE])) {
            throw new NotValidHttpMethodException();
        }

        $this->method = $method;
    }

    public function method(): string
    {
        return $this->method;
    }

    public function usePostData(): bool
    {
        return in_array($this->method, [self::HTTP_POST, self::HTTP_PUT]);
    }
}
