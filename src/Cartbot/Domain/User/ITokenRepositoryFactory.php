<?php

namespace Cartbot\Domain\User;

interface ITokenRepositoryFactory
{
    public function getRepository(string $idClient): TokenRepository;
}
