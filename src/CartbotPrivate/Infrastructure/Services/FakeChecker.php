<?php

namespace CartbotPrivate\Infrastructure\Services;

use CartbotPrivate\Domain\Services\PasswordChecker;
use CartbotPrivate\Domain\User\PasswordPlainText;
use CartbotPrivate\Domain\User\UserClient;

class FakeChecker implements PasswordChecker
{
    public const PASS = 'actual123';

    public function isValid(PasswordPlainText $password, UserClient $user): bool
    {
        return ($password->password() === self::PASS);
    }
}
