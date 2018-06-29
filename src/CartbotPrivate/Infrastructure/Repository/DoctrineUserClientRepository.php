<?php

namespace CartbotPrivate\Infrastructure\Repository;

use Doctrine\ORM\EntityRepository;
use CartbotPrivate\Domain\User\UserClient;
use CartbotPrivate\Domain\User\UserClientRepository;
use CartbotPrivate\Infrastructure\Entity\SymfonyUserClient;

class DoctrineUserClientRepository extends EntityRepository implements UserClientRepository
{
    public function save(UserClient $userClient): void
    {
        $symfonyUserClient = new SymfonyUserClient($userClient);
        $em = $this->getEntityManager();
        $em->persist($symfonyUserClient);
        $em->flush();
        $userClient->setId($symfonyUserClient->id());
    }

    public function findOneByUserName(string $userName): ?UserClient
    {
        return $this->findOneBy(['username' => $userName]);
    }
}
