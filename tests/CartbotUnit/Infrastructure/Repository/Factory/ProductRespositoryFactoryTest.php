<?php

namespace CartbotUnit\Infrastructure\Repository\Factory;

use PHPUnit\Framework\TestCase;
use Cartbot\Domain\Client\ClientNotConfigureException;
use Cartbot\Domain\Product\ProductRepository;
use Cartbot\Infrastructure\Repository\Factory\ProductRepositoryFactory;
use Cartbot\Infrastructure\Repository\UlaboxProductRepository;

class ProductRespositoryFactoryTest extends TestCase
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
        $this->assertInstanceOf(ProductRepository::class, $repository);
    }

    private function getFactory()
    {
        $repository = $this->getMockBuilder(UlaboxProductRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        return new ProductRepositoryFactory($repository);
    }
}
