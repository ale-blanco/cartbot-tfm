<?php

namespace CartbotIntegration\Application\CommandHandlers\Context;

use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;
use Cartbot\Application\CommandHandlers\NotUnderstood;
use Cartbot\Application\Commands\NotUnderstoodComm;
use Cartbot\Application\Services\FakeUserService;
use Cartbot\Domain\Chat\ChatType;
use Cartbot\Domain\User\NotUnderstoodEvent;
use Cartbot\Infrastructure\Services\FakeEventBus;

class NotUnderstoodContext implements Context
{
    private $command;
    private $userService;
    private $eventBus;

    /**
     * @Given /^a command notunderstood$/
     */
    public function aCommandOfNotunderstood()
    {
        $this->createANotUnderstoodComm();
    }

    /**
     * @When /^executing the notunderstood use case$/
     */
    public function executingTheUseCase()
    {
        $handler = new NotUnderstood($this->userService, $this->eventBus);
        $handler->__invoke($this->command);
    }

    /**
     * @Then /^send a event notunderstood$/
     */
    public function sendAEventNotunderstood()
    {
        Assert::assertTrue($this->eventBus->hasEventOfType(NotUnderstoodEvent::class));
    }

    private function createANotUnderstoodComm()
    {
        $this->command = new NotUnderstoodComm('1', ChatType::createTelegam());
        $this->userService = new FakeUserService();
        $this->eventBus = new FakeEventBus();
    }
}
