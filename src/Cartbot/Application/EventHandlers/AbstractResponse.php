<?php

namespace Cartbot\Application\EventHandlers;

use Cartbot\Domain\Chat\ISenderChatFactory;

abstract class AbstractResponse
{
    protected $senderFactory;

    public function __construct(ISenderChatFactory $senderFactory)
    {
        $this->senderFactory = $senderFactory;
    }
}
