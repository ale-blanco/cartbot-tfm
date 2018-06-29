<?php

namespace Cartbot\Infrastructure\Repository\Factory;

use Cartbot\Domain\Product\IProductRepositoryFactory;
use Cartbot\Domain\Product\ProductRepository;
use Cartbot\Infrastructure\Repository\MemoryProductRepository;

class FakeProductRepositoryFactory implements IProductRepositoryFactory
{
    private $repository;

    public function __construct()
    {
        $this->repository = new MemoryProductRepository();
    }

    public function getRepository(string $idClient): ProductRepository
    {
        return $this->repository;
    }
}
