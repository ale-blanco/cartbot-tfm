<?php

namespace Cartbot\Domain\Product;

interface IProductRepositoryFactory
{
    public function getRepository(string $idClient): ProductRepository;
}
