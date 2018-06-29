<?php

namespace CartbotPrivate\Application\CommandHandlers\Admin;

use CartbotPrivate\Application\Outputs\Admin\LastAddedOut;
use CartbotPrivate\Domain\Action\ActionRepository;

class LastSevenDaysEvents
{
    private const DAYS = 7;

    private $actionRepository;

    public function __construct(ActionRepository $actionRepository)
    {
        $this->actionRepository = $actionRepository;
    }

    public function __invoke(string $idClient): LastAddedOut
    {
        $added = $this->actionRepository->getAddedInLastDays(self::DAYS, $idClient);
        return new LastAddedOut($added);
    }
}
