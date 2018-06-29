<?php

namespace CartbotPrivateUnit\Domain\Action;

use PHPUnit\Framework\TestCase;
use CartbotPrivate\Domain\Action\FilterActions;
use Cartbot\Domain\Chat\ChatType;

class FilterActionsTest extends TestCase
{
    public function testShouldGiveMeOriginalValues()
    {
        $user = 'alex';
        $chat = ChatType::createTelegam()->name();
        $desc = 'a description';
        $filter = new FilterActions($user, $chat, $desc);
        $this->assertEquals($user, $filter->user());
        $this->assertEquals($chat, $filter->chat());
        $this->assertEquals($desc, $filter->description());
    }
}
