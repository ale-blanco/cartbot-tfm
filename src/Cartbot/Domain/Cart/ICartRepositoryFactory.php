<?php

namespace Cartbot\Domain\Cart;

interface ICartRepositoryFactory
{
    public function getRepository(string $idClient): CartRepository;
}