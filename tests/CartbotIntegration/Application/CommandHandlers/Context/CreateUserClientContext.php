<?php

namespace CartbotIntegration\Application\CommandHandlers\Context;

use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;
use CartbotPrivate\Application\CommandHandlers\CreateUserClient;
use Cartbot\Domain\Client\Client;
use Cartbot\Domain\Client\ClientNotExistException;
use CartbotPrivate\Domain\User\Email;
use CartbotPrivate\Domain\User\PasswordPlainText;
use CartbotPrivate\Domain\User\UserClient;
use CartbotPrivate\Domain\User\UserNameExistException;
use Cartbot\Infrastructure\Repository\MemoryClientRepository;
use CartbotPrivate\Infrastructure\Repository\MemoryUserClientRepository;
use CartbotPrivate\Infrastructure\Services\FakeEncoder;

class CreateUserClientContext implements Context
{
    private const USERNAME = 'thename';
    private const PASS = 'valid12';
    private $pass;
    private $email;
    private $username;
    private $idClient;

    private $clientRepository;
    private $userCRepository;
    private $encoder;

    /**
     * @Given /^a idclient that not exist$/
     */
    public function aIdclientThatNotExist()
    {
        $this->createACreateUserClientData('9999');
    }

    /**
     * @When /^executing the createuserclient use case throw an ClientNotExistException$/
     */
    public function executingTheCreateuserclientUseCaseThrowAnClientNotExistException()
    {
        $this->executeUseCaseWithException(ClientNotExistException::class);
    }

    /**
     * @Given /^a username that exist$/
     */
    public function aUsernameThatExist()
    {
        $this->createACreateUserClientData('1');
        $this->userCRepository->setList([new UserClient(
            new Client('1', 'client', '', ''),
            self::USERNAME,
            new Email('a@a.com'),
            true
        )]);
    }

    /**
     * @When /^executing the createuserclient use case throw an UserNameExistException$/
     */
    public function executingTheCreateuserclientUseCaseThrowAnUserNameExistException()
    {
        $this->executeUseCaseWithException(UserNameExistException::class);
    }

    /**
     * @Given /^a valid data$/
     */
    public function aValidData()
    {
        $this->createACreateUserClientData('1');
    }

    /**
     * @When /^executing the createuserclient use case$/
     */
    public function executingTheCreateuserclientUseCase()
    {
        $this->executeUseCase();
    }

    /**
     * @Then /^the user is create with the password encoded$/
     */
    public function thePasswordIsEncoded()
    {
        $userCreated = $this->userCRepository->findOneByUserName(self::USERNAME);
        Assert::assertNotNull($userCreated);
        Assert::assertNotEquals($userCreated->password(), self::PASS);
    }

    private function createACreateUserClientData(string $idClient)
    {
        $this->idClient = $idClient;
        $this->username = self::USERNAME;
        $this->email = new Email('a@a.com');
        $this->pass = new PasswordPlainText(self::PASS);
        $this->clientRepository = new MemoryClientRepository();
        $this->userCRepository = new MemoryUserClientRepository();
        $this->encoder = new FakeEncoder();
    }

    private function executeUseCase()
    {
        $handle = new CreateUserClient($this->clientRepository, $this->userCRepository, $this->encoder);
        $handle->__invoke($this->idClient, $this->username, $this->email, $this->pass);
    }

    private function executeUseCaseWithException(string $exceptionClass)
    {
        $exception = false;
        try {
            $this->executeUseCase();
        } catch (\Exception $ex) {
            $exception = $ex;
        }
        Assert::assertInstanceOf($exceptionClass, $exception);
    }
}
