<?php

namespace Cartbot\Domain\Client;

interface ClientRepository
{
    public function findOneByIdOrException(string $id): Client;
}
