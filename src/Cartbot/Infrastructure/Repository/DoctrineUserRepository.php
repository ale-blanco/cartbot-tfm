<?php

namespace Cartbot\Infrastructure\Repository;

use Cartbot\Domain\Client\Client;
use Cartbot\Domain\User\User;
use Cartbot\Domain\User\UserChat;
use Cartbot\Domain\User\UserRepository;
use Doctrine\ORM\EntityRepository;

class DoctrineUserRepository extends EntityRepository implements UserRepository
{
    public function getUserByNameAndClient(string $name, Client $client): ?User
    {
        return $this->findOneBy(['name' => $name, 'client' => $client]);
    }

    public function saveUser(User $user): void
    {
        $em = $this->getEntityManager();
        $em->persist($user);
        $em->flush();
    }
}
