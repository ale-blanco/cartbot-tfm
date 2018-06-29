<?php

namespace CartbotPrivateUnit\Domain\Action;

use PHPUnit\Framework\TestCase;
use CartbotPrivate\Domain\Action\Action;
use CartbotPrivate\Domain\Action\ActionType;
use Cartbot\Domain\Chat\ChatType;

class ActionTest extends TestCase
{
    public function testShouldCreateARandomId()
    {
        $action1 = new Action(
            new \DateTimeImmutable(),
            1,
            1,
            ChatType::createTelegam(),
            ActionType::cartListed(),
            ''
        );
        $action2 = new Action(
            new \DateTimeImmutable(),
            1,
            1,
            ChatType::createTelegam(),
            ActionType::cartListed(),
            ''
        );
        $this->assertNotEquals($action1->id(), $action2->id());
    }

    public function testShouldGiveMeOriginalData()
    {
        $date = new \DateTimeImmutable();
        $idClient = 1;
        $idUser = 2;
        $chat = ChatType::createTelegam();
        $type = ActionType::cartListed();
        $data = 'optionalData';

        $action = new Action($date, $idClient, $idUser, $chat, $type, $data);
        $resul = $action->toArray();

        $this->assertEquals($resul['date'], $date->format('Y-m-d H:i:s'));
        $this->assertEquals($resul['idClient'], $idClient);
        $this->assertEquals($resul['idUser'], $idUser);
        $this->assertEquals($resul['chatType'], $chat->name());
        $this->assertEquals($resul['type'], $type->type());
        $this->assertEquals($resul['data'], $data);
    }
}
