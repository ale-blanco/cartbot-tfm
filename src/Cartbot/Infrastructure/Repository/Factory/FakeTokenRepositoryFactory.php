<?php

namespace Cartbot\Infrastructure\Repository\Factory;

use Cartbot\Domain\User\ITokenRepositoryFactory;
use Cartbot\Domain\User\TokenRepository;
use Cartbot\Infrastructure\Repository\MemoryTokenRepository;

class FakeTokenRepositoryFactory implements ITokenRepositoryFactory
{
    public function getRepository(string $idClient): TokenRepository
    {
        return new MemoryTokenRepository();
    }
}
