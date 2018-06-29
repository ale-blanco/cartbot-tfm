<?php

namespace Cartbot\Application\Commands;

class AuthorizeForClientComm
{
    private $code;
    private $customerToken;
    private $userName;

    public function __construct(string $code, string $customerToken, string $userName)
    {
        $this->code = $code;
        $this->customerToken = $customerToken;
        $this->userName = $userName;
    }

    public function code(): string
    {
        return $this->code;
    }

    public function customerToken(): string
    {
        return $this->customerToken;
    }

    public function userName(): string
    {
        return $this->userName;
    }
}
