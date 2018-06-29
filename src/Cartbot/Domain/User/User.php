<?php

namespace Cartbot\Domain\User;

use Cartbot\Domain\Client\Client;

class User
{
    private $id;
    private $name;
    private $customerToken;
    private $dateRegenerated;
    private $client;

    public function __construct(
        ?string $id,
        string $name,
        CustomerToken $customerToken,
        Client $client
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->setCustomerToken($customerToken);
        $this->client = $client;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function customerToken(): CustomerToken
    {
        if ($this->dateRegenerated instanceof \DateTime) {
            $this->dateRegenerated = \DateTimeImmutable::createFromMutable($this->dateRegenerated);
        }
        return new CustomerToken($this->customerToken, $this->dateRegenerated);
    }

    public function setCustomerToken(CustomerToken $customerToken): void
    {
        $this->customerToken = $customerToken->token();
        $this->dateRegenerated = $customerToken->dateRegenerated();
    }

    public function client(): Client
    {
        return $this->client;
    }
}
