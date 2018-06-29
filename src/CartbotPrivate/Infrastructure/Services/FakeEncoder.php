<?php

namespace CartbotPrivate\Infrastructure\Services;

use CartbotPrivate\Domain\Services\PasswordEncoder;
use CartbotPrivate\Domain\User\UserClient;

class FakeEncoder implements PasswordEncoder
{
    public function encode(UserClient $userClient, string $plainTextPass): string
    {
        return md5($plainTextPass);
    }
}
