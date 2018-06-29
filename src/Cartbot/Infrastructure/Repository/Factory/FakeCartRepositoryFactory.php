<?php

namespace Cartbot\Infrastructure\Repository\Factory;

use Cartbot\Domain\Cart\CartRepository;
use Cartbot\Domain\Cart\ICartRepositoryFactory;
use Cartbot\Infrastructure\Repository\MemoryCartRepository;

class FakeCartRepositoryFactory implements ICartRepositoryFactory
{
    private $repository;

    public function __construct()
    {
        $this->repository = new MemoryCartRepository();
    }

    public function getRepository(string $idClient): CartRepository
    {
        return $this->repository;
    }
}
