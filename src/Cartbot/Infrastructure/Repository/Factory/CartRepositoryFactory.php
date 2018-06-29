<?php

namespace Cartbot\Infrastructure\Repository\Factory;

use Cartbot\Domain\Cart\CartRepository;
use Cartbot\Domain\Cart\ICartRepositoryFactory;
use Cartbot\Domain\Client\ClientNotConfigureException;
use Cartbot\Infrastructure\Repository\UlaboxCartRepository;

class CartRepositoryFactory implements ICartRepositoryFactory
{
    private $repos;

    public function __construct(UlaboxCartRepository $ulaboxCartRepository)
    {
        $this->repos = [
            '1' => $ulaboxCartRepository
        ];
    }

    public function getRepository(string $idClient): CartRepository
    {
        if (!isset($this->repos[$idClient])) {
            throw new ClientNotConfigureException();
        }

        return $this->repos[$idClient];
    }
}
