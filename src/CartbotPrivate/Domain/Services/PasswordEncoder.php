<?php

namespace CartbotPrivate\Domain\Services;

use CartbotPrivate\Domain\User\UserClient;

interface PasswordEncoder
{
    public function encode(UserClient $userClient, string $plainTextPass): string;
}
