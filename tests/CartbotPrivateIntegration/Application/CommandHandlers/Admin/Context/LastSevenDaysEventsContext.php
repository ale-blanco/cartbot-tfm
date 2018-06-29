<?php

namespace CartbotPrivateIntegration\Application\CommandHandlers\Admin\Context;

use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;
use CartbotPrivate\Application\CommandHandlers\Admin\LastSevenDaysEvents;
use CartbotPrivate\Application\Outputs\Admin\LastAddedOut;
use CartbotPrivate\Infrastructure\Repository\MemoryActionRepository;

class LastSevenDaysEventsContext implements Context
{
    private $repostiory;
    private $idClient;
    private $result;

    /**
     * @Given /^a number of client$/
     */
    public function aNumberOfClient()
    {
        $this->createIdClientAndRepository();
    }

    /**
     * @When /^executing the lastsevendaysevents use case$/
     */
    public function executingTheLastsevendayseventsUseCase()
    {
        $handle = new LastSevenDaysEvents($this->repostiory);
        $this->result = $handle->__invoke($this->idClient);
    }

    /**
     * @Then /^response a lastaddedout with data$/
     */
    public function responseALastaddedoutWithData()
    {
        Assert::assertInstanceOf(LastAddedOut::class, $this->result);
    }

    private function createIdClientAndRepository()
    {
        $this->idClient = '1';
        $this->repostiory = new MemoryActionRepository();
    }
}
