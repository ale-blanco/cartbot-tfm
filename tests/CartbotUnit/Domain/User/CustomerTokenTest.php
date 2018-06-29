<?php

namespace CartbotUnit\Domain\User;

use PHPUnit\Framework\TestCase;
use Cartbot\Domain\User\CustomerToken;

class CustomerTokenTest extends TestCase
{
    const HOURS = 24;

    public function testShouldNotBeValidAfterXHours()
    {
        $token = new CustomerToken('data', new \DateTimeImmutable('-' . self::HOURS . ' hours'));
        $this->assertFalse($token->isValid());
    }

    public function testShouldBeVAlidBeforesXHours()
    {
        $token = new CustomerToken('data', new \DateTimeImmutable('-' . (self::HOURS - 1) . ' hours'));
        $this->assertTrue($token->isValid());
    }
}
