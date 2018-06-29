<?php

namespace CartbotPrivateIntegration\Application\CommandHandlers\Admin\Context;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use CartbotPrivate\Domain\User\PasswordEqualActualException;
use PHPUnit\Framework\Assert;
use CartbotPrivate\Application\CommandHandlers\Admin\ChangePass;
use CartbotPrivate\Application\Outputs\Admin\OkOut;
use Cartbot\Domain\Client\Client;
use CartbotPrivate\Domain\User\Email;
use CartbotPrivate\Domain\User\PasswordNotValidException;
use CartbotPrivate\Domain\User\PasswordPlainText;
use CartbotPrivate\Domain\User\UserClient;
use CartbotPrivate\Infrastructure\Repository\MemoryUserClientRepository;
use CartbotPrivate\Infrastructure\Services\FakeChecker;
use CartbotPrivate\Infrastructure\Services\FakeEncoder;

class ChangePassContext implements Context
{
    private const NEW = 'new123';
    private const USER_NAME = 'username';

    private $encoder;
    private $checker;
    private $repository;
    private $actualPass;
    private $newPass;
    private $user;
    private $response;

    /**
     * @Given /^a actual password that is not valid$/
     */
    public function aActualPasswordThatIsNotValid()
    {
        $this->createDataReceive('invalid123');
    }

    /**
     * @When /^executing the changepass use case throw an PasswordNotValidException$/
     */
    public function executingTheChangepassUseCaseThrowAnPasswordNotValidException()
    {
        $exception = false;
        try {
            $this->executeTheUseCase();
        } catch (PasswordNotValidException $ex) {
            $exception = true;
        }
        Assert::assertTrue($exception);
    }


    /**
     * @Given /^a actual and new pass valid$/
     */
    public function aActualAndNewPassValid()
    {
        $this->createDataReceive(FakeChecker::PASS);
    }

    /**
     * @When /^executing the changepass use case$/
     */
    public function executingTheChangepassUseCase()
    {
        $this->executeTheUseCase();
    }

    /**
     * @Then /^response a OK and the user is saved$/
     */
    public function responseAOKAndTheUserIsSaved()
    {
        Assert::assertInstanceOf(OkOut::class, $this->response);
        Assert::assertNotNull($this->repository->findOneByUserName(self::USER_NAME));
    }

    /**
     * @Given /^a new password that is equal the actual$/
     */
    public function aNewPasswordThatIsEqualTheActual()
    {
        $this->createDataReceive(FakeChecker::PASS, FakeChecker::PASS);
    }

    /**
     * @When /^executing the changepass use case throw an PasswordEqualActualException$/
     */
    public function executingTheChangepassUseCaseThrowAnPasswordEqualActualException()
    {
        $exception = false;
        try {
            $this->executeTheUseCase();
        } catch (PasswordEqualActualException $ex) {
            $exception = true;
        }
        Assert::assertTrue($exception);
    }

    private function createDataReceive(string $actualPass, string $newPass = self::NEW)
    {
        $this->encoder = new FakeEncoder();
        $this->checker = new FakeChecker();
        $this->repository = new MemoryUserClientRepository();
        $this->actualPass = new PasswordPlainText($actualPass);
        $this->newPass = new PasswordPlainText($newPass);
        $this->user = new UserClient(
            new Client('1', 'cliente', '', ''),
            self::USER_NAME,
            new Email('a@a.com'),
            true
        );
    }

    private function executeTheUseCase(): void
    {
        $handle = new ChangePass($this->checker, $this->encoder, $this->repository);
        $this->response = $handle->__invoke($this->actualPass, $this->newPass, $this->user);
    }
}
