<?php

namespace CartbotPrivateUnit\Domain\Action;

use PHPUnit\Framework\TestCase;
use CartbotPrivate\Domain\Action\ActionType;
use CartbotPrivate\Domain\Action\ActionTypeNotValidException;

class ActionTypeTest extends TestCase
{
    public function testShouldThrowExceptionIfNotValidType()
    {
        $this->expectException(ActionTypeNotValidException::class);
        new ActionType('not valid');
    }

    public function testShouldEqualsIfValueIsEqual()
    {
        $type1 = ActionType::productAdded();
        $type2 = ActionType::productAdded();
        $this->assertTrue($type1->equal($type2));
    }
}
