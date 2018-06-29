<?php

namespace CartbotPrivate\Domain\Services;

use CartbotPrivate\Domain\User\PasswordPlainText;
use CartbotPrivate\Domain\User\UserClient;

interface PasswordChecker
{
    public function isValid(PasswordPlainText $password, UserClient $user): bool;
}
