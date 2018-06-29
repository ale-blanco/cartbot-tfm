<?php

namespace CartbotUnit\Infrastructure\Repository\Factory;

use PHPUnit\Framework\TestCase;
use Cartbot\Domain\Cart\CartRepository;
use Cartbot\Domain\Client\ClientNotConfigureException;
use Cartbot\Infrastructure\Repository\Factory\CartRepositoryFactory;
use Cartbot\Infrastructure\Repository\UlaboxCartRepository;

class CartRepositoryFactoryTest extends TestCase
{
    public function testShouldThrownExceptionWhenIdClientIsNotConfigure()
    {
        $this->expectException(ClientNotConfigureException::class);
        $factory = $this->getFactory();
        $factory->getRepository(9999999);
    }

    public function testShouldGiveMeARepositoryIfIdClientIsConfigure()
    {
        $factory = $this->getFactory();
        $repository = $factory->getRepository(1);
        $this->assertInstanceOf(CartRepository::class, $repository);
    }

    private function getFactory()
    {
        $repository = $this->getMockBuilder(UlaboxCartRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        return new CartRepositoryFactory($repository);
    }
}
