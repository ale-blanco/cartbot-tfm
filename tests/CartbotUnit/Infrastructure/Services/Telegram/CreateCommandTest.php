<?php

namespace CartbotUnit\Infrastructure\Services\Telegram;

use PHPUnit\Framework\TestCase;
use Cartbot\Application\Commands\AddProductComm;
use Cartbot\Application\Commands\ListCartComm;
use Cartbot\Application\Commands\NotUnderstoodComm;
use Cartbot\Application\Commands\StartComm;
use Cartbot\Application\Services\UserService;
use Cartbot\Domain\Chat\ChatType;
use Cartbot\Domain\Chat\MessageChat;
use Cartbot\Infrastructure\Services\Telegram\CreateCommand;

class CreateCommandTest extends TestCase
{
    public function testShouldGiveMeAStartCommand()
    {
        $service = $this->getService();
        $result = $service->create(new MessageChat('/start', '1', ChatType::createTelegam(), '1'));
        $this->assertInstanceOf(StartComm::class, $result);
    }

    public function testShouldGiveMeAListCartCommand()
    {
        $service = $this->getService();
        $result = $service->create(new MessageChat('carrito', '1', ChatType::createTelegam(), '1'));
        $this->assertInstanceOf(ListCartComm::class, $result);
    }

    public function testShouldGiveMeAAddProductCommand()
    {
        $service = $this->getService();
        $result = $service->create(new MessageChat('añadir producto buscado', '1', ChatType::createTelegam(), '1'));
        $this->assertInstanceOf(AddProductComm::class, $result);
    }

    /**
     * @dataProvider messagesNotValid
     */
    public function testShouldGiveMeANotUnderstoodCommand(string $text)
    {
        $service = $this->getService();
        $result = $service->create(new MessageChat($text, '1', ChatType::createTelegam(), '1'));
        $this->assertInstanceOf(NotUnderstoodComm::class, $result);
    }

    private function getService(): CreateCommand
    {
        $userService = $this->getMockBuilder(UserService::class)
            ->disableOriginalConstructor()
            ->getMock();
        return new CreateCommand($userService);
    }

    public function messagesNotValid()
    {
        return [
            [''],
            ['dlsakfdlkasfj lsdfds'],
            ['añadir'],
            ['12'],
            ['start'],
            ['ver carrito']
        ];
    }
}
