<?php

namespace Cartbot\Infrastructure\Repository;

use Cartbot\Domain\User\NotUserStartForCodeException;
use Cartbot\Domain\User\UserStart;
use Cartbot\Domain\User\UserStartRepository;
use Doctrine\ORM\EntityRepository;

class DoctrineUserStartRepository extends EntityRepository implements UserStartRepository
{
    public function save(UserStart $userStart): void
    {
        $em = $this->getEntityManager();
        $em->persist($userStart);
        $em->flush();
    }

    public function findOneByCodeOrException(string $code): UserStart
    {
        $userStart = $this->findOneByCode($code);
        if ($userStart == null) {
            throw new NotUserStartForCodeException();
        }

        return $userStart;
    }

    public function findOneByCode(string $code): ?UserStart
    {
        return $this->findOneBy(['code' => $code]);
    }
}
