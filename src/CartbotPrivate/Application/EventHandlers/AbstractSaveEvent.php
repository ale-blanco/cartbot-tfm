<?php

namespace CartbotPrivate\Application\EventHandlers;

use CartbotPrivate\Domain\Action\ActionRepository;

abstract class AbstractSaveEvent
{
    protected $actionRepository;

    public function __construct(ActionRepository $actionRepository)
    {
        $this->actionRepository = $actionRepository;
    }
}
