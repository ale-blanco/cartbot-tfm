<?php

namespace Cartbot\Infrastructure\Repository;

use Doctrine\ORM\EntityRepository;
use Cartbot\Domain\Client\Client;
use Cartbot\Domain\Client\ClientNotExistException;
use Cartbot\Domain\Client\ClientRepository;

class DoctrineClientRepository extends EntityRepository implements ClientRepository
{
    public function findOneByIdOrException(string $id): Client
    {
        $client = $this->findOneBy(['id' => $id]);
        if (!$client) {
            throw new ClientNotExistException();
        }

        return $client;
    }
}
