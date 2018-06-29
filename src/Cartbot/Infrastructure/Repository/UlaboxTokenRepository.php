<?php

namespace Cartbot\Infrastructure\Repository;

use Cartbot\Domain\User\CustomerToken;
use Cartbot\Domain\User\TokenRepository;
use UlaboxApi\Actions\Authentication\RefreshCustomerToken;
use UlaboxApi\Sender;

class UlaboxTokenRepository implements TokenRepository
{
    private $sender;

    public function __construct(Sender $sender)
    {
        $this->sender = $sender;
    }

    public function refreshToken(CustomerToken $customerToken): CustomerToken
    {
        $newToken = $this->sender->send(new RefreshCustomerToken($customerToken->token()));
        return new CustomerToken($newToken, new \DateTimeImmutable());
    }
}
