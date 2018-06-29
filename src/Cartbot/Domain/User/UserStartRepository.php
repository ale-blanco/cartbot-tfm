<?php

namespace Cartbot\Domain\User;

interface UserStartRepository
{
    public function save(UserStart $userStart): void;

    public function findOneByCodeOrException(string $code): UserStart;

    public function findOneByCode(string $code): ?UserStart;
}