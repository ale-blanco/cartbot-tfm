<?php

namespace Cartbot\Domain\User;

class CustomerToken
{
    private const HOURS_VALID = 24;
    private $customerToken;
    private $dateRegenerated;

    public function __construct(string $customerToken, \DateTimeImmutable $dateRegenerated)
    {
        $this->customerToken = $customerToken;
        $this->dateRegenerated = $dateRegenerated;
    }

    public function token(): string
    {
        return $this->customerToken;
    }

    public function dateRegenerated(): \DateTimeImmutable
    {
        return $this->dateRegenerated;
    }

    public function isValid(): bool
    {
        $now = new \DateTimeImmutable();
        $dateExpiration = $this->dateRegenerated->add(new \DateInterval('PT' . self::HOURS_VALID . 'H'));
        return $now < $dateExpiration;
    }
}
