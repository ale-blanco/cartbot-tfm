<?php

namespace CartbotUnit\Domain\Chat;

use Cartbot\Domain\Chat\ChatTypeNotValidException;
use PHPUnit\Framework\TestCase;
use Cartbot\Domain\Chat\ChatType;

class ChatTypeTest extends TestCase
{
    public function testShouldEqualsTwoChatTypeOfSameType()
    {
        $chatType1 = ChatType::createTelegam();
        $chatType2 = ChatType::createTelegam();
        $this->assertTrue($chatType1->isEqual($chatType2));
    }

    public function testShoudThrownExceptionIfNotValidTypeNae()
    {
        $this->expectException(ChatTypeNotValidException::class);
        $type = new ChatType('notvalid');
    }
}
