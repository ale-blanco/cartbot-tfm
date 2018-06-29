<?php

namespace CartbotUnit\Infrastructure\Repository\Factory;

use PHPUnit\Framework\TestCase;
use Cartbot\Domain\Client\ClientNotConfigureException;
use Cartbot\Domain\User\TokenRepository;
use Cartbot\Infrastructure\Repository\Factory\TokenRepositoryFactory;
use Cartbot\Infrastructure\Repository\UlaboxTokenRepository;

class UserRepositoryFactoryTest extends TestCase
{
    public function testShouldThrownExceptionIfIdClientIsNotConfigure()
    {
        $this->expectException(ClientNotConfigureException::class);
        $factory = $this->getFactory();
        $factory->getRepository(9999999);
    }

    public function testShouldGiveMeARepositoryIfIdClientIsConfigure()
    {
        $factory = $this->getFactory();
        $repository = $factory->getRepository(1);
        $this->assertInstanceOf(TokenRepository::class, $repository);
    }

    private function getFactory()
    {
        $repository = $this->getMockBuilder(UlaboxTokenRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        return new TokenRepositoryFactory($repository);
    }
}
