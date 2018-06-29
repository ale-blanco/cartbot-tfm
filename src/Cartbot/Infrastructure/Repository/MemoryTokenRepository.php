<?php

namespace Cartbot\Infrastructure\Repository;

use Cartbot\Domain\User\CustomerToken;
use Cartbot\Domain\User\TokenRepository;

class MemoryTokenRepository implements TokenRepository
{
    public function refreshToken(CustomerToken $customerToken): CustomerToken
    {
        return new CustomerToken(microtime(), new \DateTimeImmutable());
    }
}
