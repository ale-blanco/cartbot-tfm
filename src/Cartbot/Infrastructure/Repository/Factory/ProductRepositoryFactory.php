<?php

namespace Cartbot\Infrastructure\Repository\Factory;

use Cartbot\Domain\Client\ClientNotConfigureException;
use Cartbot\Domain\Product\IProductRepositoryFactory;
use Cartbot\Domain\Product\ProductRepository;
use Cartbot\Infrastructure\Repository\UlaboxProductRepository;

class ProductRepositoryFactory implements IProductRepositoryFactory
{
    private $repos;

    public function __construct(UlaboxProductRepository $ulaboxProductRepository)
    {
        $this->repos = [
            '1' => $ulaboxProductRepository
        ];
    }

    public function getRepository(string $idClient): ProductRepository
    {
        if (!isset($this->repos[$idClient])) {
            throw new ClientNotConfigureException();
        }

        return $this->repos[$idClient];
    }
}
