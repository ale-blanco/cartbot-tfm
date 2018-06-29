<?php

namespace Cartbot\Infrastructure\Repository\Factory;

use Cartbot\Domain\Client\ClientNotConfigureException;
use Cartbot\Domain\User\ITokenRepositoryFactory;
use Cartbot\Domain\User\TokenRepository;
use Cartbot\Infrastructure\Repository\UlaboxTokenRepository;

class TokenRepositoryFactory implements ITokenRepositoryFactory
{
    private $repos;

    public function __construct(UlaboxTokenRepository $ulaboxUserRepository)
    {
        $this->repos = [
            '1' => $ulaboxUserRepository
        ];
    }

    public function getRepository(string $idClient): TokenRepository
    {
        if (!isset($this->repos[$idClient])) {
            throw new ClientNotConfigureException();
        }

        return $this->repos[$idClient];
    }
}
