<?php

namespace Cartbot\Infrastructure\Repository;

use Cartbot\Domain\Client\Client;
use Cartbot\Domain\Client\ClientNotExistException;
use Cartbot\Domain\Client\ClientRepository;

class MemoryClientRepository implements ClientRepository
{
    public function findOneByIdOrException(string $id): Client
    {
        if ($id !== '1') {
            throw new ClientNotExistException();
        }

        return new Client('1', 'client1', '', '');
    }
}
