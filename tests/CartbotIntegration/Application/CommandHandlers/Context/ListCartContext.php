<?php

namespace CartbotIntegration\Application\CommandHandlers\Context;

use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;
use Cartbot\Application\CommandHandlers\ListCart;
use Cartbot\Application\Commands\ListCartComm;
use Cartbot\Application\Services\FakeUserService;
use Cartbot\Domain\Cart\ListCartEvent;
use Cartbot\Domain\Chat\ChatType;
use Cartbot\Infrastructure\Repository\Factory\FakeCartRepositoryFactory;
use Cartbot\Infrastructure\Services\FakeEventBus;

class ListCartContext implements Context
{
    private $factory;
    private $eventBus;
    private $userService;
    private $command;

    /**
     * @Given /^a listcart command$/
     */
    public function aListcartCommand()
    {
        $this->createAListCartComm();
    }

    /**
     * @When /^executing the listcart use case$/
     */
    public function executingTheUseCase()
    {
        $handler = new ListCart($this->userService, $this->factory, $this->eventBus);
        $handler->__invoke($this->command);
    }

    /**
     * @Then /^send a event listcart$/
     */
    public function sendAEventListcart()
    {
        Assert::assertTrue($this->eventBus->hasEventOfType(ListCartEvent::class));
    }

    private function createAListCartComm()
    {
        $this->command = new ListCartComm('1', ChatType::createTelegam());
        $this->userService = new FakeUserService();
        $this->eventBus = new FakeEventBus();
        $this->factory = new FakeCartRepositoryFactory();
    }
}