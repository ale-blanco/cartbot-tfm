<?php

namespace CartbotIntegration\Application\CommandHandlers\Context;

use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;
use Cartbot\Application\CommandHandlers\AddProduct;
use Cartbot\Application\Commands\AddProductComm;
use Cartbot\Application\Services\FakeUserService;
use Cartbot\Domain\Chat\ChatType;
use Cartbot\Domain\Product\AddProductEvent;
use Cartbot\Domain\Product\ListProduct;
use Cartbot\Domain\Product\NotFindedProductException;
use Cartbot\Domain\Product\Product;
use Cartbot\Infrastructure\Repository\Factory\FakeCartRepositoryFactory;
use Cartbot\Infrastructure\Repository\Factory\FakeProductRepositoryFactory;
use Cartbot\Infrastructure\Services\FakeEventBus;

class AddProductContext implements Context
{
    private $cartFactory;
    private $productFactory;
    private $eventBus;
    private $command;
    private $userService;

    /**
     * @Given /^a product that not exist$/
     */
    public function aProductThatNotExist()
    {
        $this->createAAddProductComm('producto que no existe');
    }

    /**
     * @When /^executing the addproduct use case throw an NotFindedProductException$/
     */
    public function executingTheAddproductUseCase()
    {
        $exception = false;
        try {
            $this->executeTheUseCase();
        } catch (NotFindedProductException $ex) {
            $exception = true;
        }
        Assert::assertTrue($exception);
    }

    /**
     * @Given /^a product that exist$/
     */
    public function aProductThatExist()
    {
        $this->createAAddProductComm('producto existente');
        $list = new ListProduct([new Product('1', 'product', '', '0')]);
        $this->productFactory->getRepository(1)->setResulSearch($list);
    }

    /**
     * @When /^executing the addproduct use case$/
     */
    public function executingTheAddproductUseCase1()
    {
        $this->executeTheUseCase();
    }

    /**
     * @Then /^send a event addproduct$/
     */
    public function sendAEventAddproduct()
    {
        Assert::assertTrue($this->eventBus->hasEventOfType(AddProductEvent::class));
    }

    private function createAAddProductComm(string $query)
    {
        $this->command = new AddProductComm('1', ChatType::createTelegam(), $query);
        $this->userService = new FakeUserService();
        $this->eventBus = new FakeEventBus();
        $this->productFactory = new FakeProductRepositoryFactory();
        $this->cartFactory = new FakeCartRepositoryFactory();
    }

    private function executeTheUseCase()
    {
        $handler = new AddProduct($this->userService, $this->productFactory, $this->cartFactory, $this->eventBus);
        $handler->__invoke($this->command);
    }
}
