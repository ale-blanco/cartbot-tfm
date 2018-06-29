<?php

namespace CartbotIntegration\Application\User\Context;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Cartbot\Infrastructure\Repository\MemoryUserRepository;
use PHPUnit\Framework\Assert;
use Cartbot\Application\Services\UserService;
use Cartbot\Domain\Chat\ChatType;
use Cartbot\Domain\User\UserChat;
use Cartbot\Domain\User\UserChatNotRegisteredException;
use Cartbot\Infrastructure\Repository\Factory\FakeTokenRepositoryFactory;
use Cartbot\Infrastructure\Repository\MemoryUserChatRepository;

class UserServiceContext implements Context
{
    private $userRepository;
    private $idChat;
    private $chatType;
    private $ucRepository;
    private $userFactory;
    private $result;

    /**
     * @Given /^a id chat that is not registered$/
     */
    public function aActualIdChatThatIsNotRegistered()
    {
        $this->createDataAndRequeriments('99999');
    }

    /**
     * @When /^executing the userservice throw an UserChatNotRegisteredException$/
     */
    public function executingTheUserserviceThrowAnUserChatNotRegisteredException()
    {
        $this->executeWithException(UserChatNotRegisteredException::class);
    }

    /**
     * @Given /^a id chat valid and token is valid$/
     */
    public function aIdChatValidAndTokenIsValid()
    {
        $this->createDataAndRequeriments('1');
    }

    /**
     * @When /^executing the userservice$/
     */
    public function executingTheUserservice()
    {
        $this->executeService();
    }

    /**
     * @Then /^response an UserChat and the token is not refreshed$/
     */
    public function responseAnUserChatAndTheTokenIsNotRefreshed()
    {
        Assert::assertInstanceOf(UserChat::class, $this->result);
        Assert::assertEquals($this->result->user()->customerToken()->token(), '1');
    }

    /**
     * @Given /^a id chat valid and token is not valid$/
     */
    public function aIdChatValidAndTokenIsNotValid()
    {
        $this->createDataAndRequeriments('2');
    }

    /**
     * @Then /^response an UserChat and the token is refreshed and saved$/
     */
    public function responseAnUserChatAndTheTokenIsRefreshedAndSaved()
    {
        Assert::assertInstanceOf(UserChat::class, $this->result);
        Assert::assertNotEquals($this->result->user()->customerToken()->token(), '2');
        Assert::assertEquals($this->userRepository->numberSaved(), 1);
    }

    private function createDataAndRequeriments(string $idChat)
    {
        $this->idChat = $idChat;
        $this->chatType = ChatType::createTelegam();
        $this->ucRepository = new MemoryUserChatRepository();
        $this->userFactory = new FakeTokenRepositoryFactory();
        $this->userRepository = new MemoryUserRepository();
    }

    private function executeWithException(string $class)
    {
        try {
            $this->executeService();
        } catch (\Exception $ex) {
            Assert::assertInstanceOf($class, $ex);
            return;
        }

        Assert::assertTrue(false);
    }

    private function executeService()
    {
        $service = new UserService($this->ucRepository, $this->userFactory, $this->userRepository);
        $this->result = $service->getUserWithValidToken($this->idChat, $this->chatType);
    }
}
