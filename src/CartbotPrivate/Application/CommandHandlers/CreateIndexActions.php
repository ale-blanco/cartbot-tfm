<?php

namespace CartbotPrivate\Application\CommandHandlers;

use CartbotPrivate\Domain\Action\ActionRepository;
use CartbotPrivate\Domain\Action\IndexAlreadyCreatedException;

class CreateIndexActions
{
    private $actionRepository;

    public function __construct(ActionRepository $actionRepository)
    {
        $this->actionRepository = $actionRepository;
    }

    public function __invoke(): void
    {
        if ($this->actionRepository->indexExist()) {
            throw new IndexAlreadyCreatedException();
        }

        $this->actionRepository->createIndex();
    }
}
