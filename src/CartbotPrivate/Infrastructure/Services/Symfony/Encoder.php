<?php

namespace CartbotPrivate\Infrastructure\Services\Symfony;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use CartbotPrivate\Domain\Services\PasswordEncoder;
use CartbotPrivate\Domain\User\UserClient;
use CartbotPrivate\Infrastructure\Entity\SymfonyUserClient;

class Encoder implements PasswordEncoder
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function encode(UserClient $userClient, string $plainTextPass): string
    {
        return $this->encoder->encodePassword(new SymfonyUserClient($userClient), $plainTextPass);
    }
}
