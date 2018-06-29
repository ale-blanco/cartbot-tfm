<?php

namespace Cartbot\Domain\User;

interface TokenRepository
{
    public function refreshToken(CustomerToken $customerToken): CustomerToken;
}
