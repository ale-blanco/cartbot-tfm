<?php

namespace Cartbot\Domain\User;

use Cartbot\Domain\DomainException;

class UserChatNotRegisteredException extends DomainException
{
    public function __construct()
    {
        parent::__construct('User chat not registered');
    }
}
