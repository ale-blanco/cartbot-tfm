<?php

namespace CartbotPrivateUnit\Domain\Action;

use PHPUnit\Framework\TestCase;
use CartbotPrivate\Domain\Action\SortActions;
use CartbotPrivate\Domain\ValidateException;

class SortActionsTest extends TestCase
{
    /**
     * @dataProvider ordersNotValid
     */
    public function testShouldThrowExceptionIfNotValidOrder(string $order)
    {
        $this->expectException(ValidateException::class);
        new SortActions($order);
    }

    public function testShouldGiveMeDirectionAndKey()
    {
        $sort = new SortActions('-user');
        $this->assertEquals('desc', $sort->direction());
        $this->assertEquals('idUser', $sort->key());

        $sort = new SortActions('+chat');
        $this->assertEquals('asc', $sort->direction());
        $this->assertEquals('chatType.keyword', $sort->key());
    }

    public function ordersNotValid()
    {
        return [['user'], ['invalid'], ['type+'], ['']];
    }
}
