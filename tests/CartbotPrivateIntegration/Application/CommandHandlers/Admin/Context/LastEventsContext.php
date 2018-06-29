<?php

namespace CartbotPrivateIntegration\Application\CommandHandlers\Admin\Context;

use Behat\Behat\Context\Context;
use CartbotPrivate\Domain\Action\ActionType;
use PHPUnit\Framework\Assert;
use CartbotPrivate\Application\CommandHandlers\Admin\LastEvents;
use CartbotPrivate\Application\Outputs\Admin\LastsEventsOut;
use CartbotPrivate\Infrastructure\Repository\MemoryActionRepository;

class LastEventsContext implements Context
{
    private $repository;
    private $idClient;
    private $result;

    /**
     * @Given /^a number of client for lastevents$/
     */
    public function aNumberOfClientForLastevents()
    {
        $this->createIdclientAndRepository();
    }

    /**
     * @When /^executing the lastevents use case$/
     */
    public function executingTheLasteventsUseCase()
    {
        $handle = new LastEvents($this->repository);
        $this->result = $handle->__invoke($this->idClient);
    }

    /**
     * @Then /^response a lastseventsout with data$/
     */
    public function responseALastseventsoutWithData()
    {
        Assert::assertInstanceOf(LastsEventsOut::class, $this->result);

        $resultRepo = $this->repository->getLastEvents('1');
        $result = json_decode(json_encode($this->result), true);

        Assert::assertEquals($result['byType'], [
            ActionType::notUnderstood()->prettyType() => 103,
            ActionType::productAdded()->prettyType() => 81,
            ActionType::cartListed()->prettyType() => 81
        ]);
        Assert::assertEquals(count($result['byHour']), count($resultRepo));
    }

    private function createIdclientAndRepository()
    {
        $this->idClient = '1';
        $this->repository = new MemoryActionRepository();
    }
}
