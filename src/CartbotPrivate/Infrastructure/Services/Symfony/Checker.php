<?php

namespace CartbotPrivate\Infrastructure\Services\Symfony;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use CartbotPrivate\Domain\Services\PasswordChecker;
use CartbotPrivate\Domain\User\PasswordPlainText;
use CartbotPrivate\Domain\User\UserClient;
use CartbotPrivate\Infrastructure\Entity\SymfonyUserClient;

class Checker implements PasswordChecker
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function isValid(PasswordPlainText $password, UserClient $user): bool
    {
        return $this->encoder->isPasswordValid(new SymfonyUserClient($user), $password->password());
    }
}
