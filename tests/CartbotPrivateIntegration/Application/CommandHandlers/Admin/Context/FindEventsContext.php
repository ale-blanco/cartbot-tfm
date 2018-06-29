<?php

namespace CartbotPrivateIntegration\Application\CommandHandlers\Admin\Context;

use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;
use CartbotPrivate\Application\CommandHandlers\Admin\FindEvents;
use CartbotPrivate\Application\Outputs\Admin\FindEventsOut;
use CartbotPrivate\Domain\Action\ActionType;
use CartbotPrivate\Domain\Action\FilterActions;
use CartbotPrivate\Domain\ValidateException;
use CartbotPrivate\Infrastructure\Repository\MemoryActionRepository;

class FindEventsContext implements Context
{
    private $type;
    private $dateStart;
    private $dateEnd;
    private $page;
    private $order;
    private $filter;
    private $idClient;
    private $repository;
    private $result;

    /**
     * @Given /^a not valid type to filter$/
     */
    public function aNotValidTypeToFilter()
    {
        $this->createDataAndRepository('invalid');
    }

    /**
     * @When /^executing the findevents use case throw an ValidateException with key type$/
     */
    public function executingTheFindeventsUseCaseThrowAnValidateExceptionWithKeyType()
    {
        $this->executeWithValidateExceptionAndKey('type');
    }

    /**
     * @Given /^a not valid start date$/
     */
    public function aNotValidStartDate()
    {
        $this->createDataAndRepository(null, '12-12');
    }

    /**
     * @When /^executing the findevents use case throw an ValidateException with key dateStart$/
     */
    public function executingTheFindeventsUseCaseThrowAnValidateExceptionWithKeyDateStart()
    {
        $this->executeWithValidateExceptionAndKey('dateStart');
    }

    /**
     * @Given /^a not valid end date$/
     */
    public function aNotValidEndDate()
    {
        $this->createDataAndRepository(null, null, '');
    }

    /**
     * @When /^executing the findevents use case throw an ValidateException with key dateEnd$/
     */
    public function executingTheFindeventsUseCaseThrowAnValidateExceptionWithKeyDateEnd()
    {
        $this->executeWithValidateExceptionAndKey('dateEnd');
    }

    /**
     * @Given /^a not valid page whit value (.*)$/
     */
    public function aNotValid($page)
    {
        $this->createDataAndRepository(null, null, null, $page);
    }

    /**
     * @When /^executing the findevents use case throw an ValidateException with key page$/
     */
    public function executingTheFindeventsUseCaseThrowAnValidateExceptionWithKeyPage()
    {
        $this->executeWithValidateExceptionAndKey('page');
    }

    /**
     * @Given /^a not valid order$/
     */
    public function aNotValidOrder()
    {
        $this->createDataAndRepository(null, null, null, null, 'algo');
    }

    /**
     * @When /^executing the findevents use case throw an ValidateException with key order$/
     */
    public function executingTheFindeventsUseCaseThrowAnValidateExceptionWithKeyOrder()
    {
        $this->executeWithValidateExceptionAndKey('order');
    }

    /**
     * @Given /^a valid data filters$/
     */
    public function aValidDataFilters()
    {
        $this->createDataAndRepository();
    }

    /**
     * @When /^executing the findevents use case$/
     */
    public function executingTheFindeventsUseCase()
    {
        $this->executeTheUseCase();
    }

    /**
     * @Then /^response a FindEventsOut$/
     */
    public function responseAFindEventsOut()
    {
        Assert::assertInstanceOf(FindEventsOut::class, $this->result);
    }

    private function createDataAndRepository(
        ?string $type = null,
        ?string $dateStart = null,
        ?string $dateEnd = null,
        ?string $page = null,
        ?string $order = null
    ) {
        $this->type = $type ?? ActionType::productAdded()->type();
        $this->dateStart = $dateStart ?? '01/01/2018';
        $this->dateEnd = $dateEnd ?? '01/01/2018';
        $this->page = $page ?? 1;
        $this->order = $order ?? '+date';
        $this->filter = new FilterActions('', '', '');
        $this->idClient = '1';
        $this->repository = new MemoryActionRepository();
    }

    private function executeTheUseCase()
    {
        $handle = new FindEvents($this->repository);
        $this->result = $handle->__invoke(
            $this->type,
            $this->dateStart,
            $this->dateEnd,
            $this->page,
            $this->order,
            $this->filter,
            $this->idClient
        );
    }

    private function executeWithValidateExceptionAndKey(string $key)
    {
        try {
            $this->executeTheUseCase();
        } catch (\Exception $ex) {
            Assert::assertInstanceOf(ValidateException::class, $ex);
            $arrayMessage = json_decode($ex->getMessage(), true);
            Assert::assertTrue(isset($arrayMessage[$key]));
            return;
        }

        Assert::assertTrue(false);
    }
}
