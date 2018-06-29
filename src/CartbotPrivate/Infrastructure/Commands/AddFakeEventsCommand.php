<?php

namespace CartbotPrivate\Infrastructure\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use CartbotPrivate\Domain\Action\Action;
use CartbotPrivate\Domain\Action\ActionRepository;
use CartbotPrivate\Domain\Action\ActionType;
use Cartbot\Domain\Chat\ChatType;

class AddFakeEventsCommand extends Command
{
    private $actionRepository;

    public function __construct(ActionRepository $actionRepository)
    {
        $this->actionRepository = $actionRepository;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('fake:addEvents')
            ->setDescription('Añade eventos de pruebas para los ultimos 10 dias');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $now = new \DateTimeImmutable('+20 days');
        $date = new \DateTimeImmutable('-10 days');
        do {
            $this->addEventsHour($date, $output);
            $date = $date->add(new \DateInterval('PT1H'));
        } while ($date < $now);
    }

    private function addEventsHour(\DateTimeImmutable $date, OutputInterface $output): void
    {
        $types = [ActionType::productAdded(), ActionType::cartListed(), ActionType::notUnderstood()];
        $total = $this->rand();
        $output->writeln('Guardando ' . $total . ' eventos para la fecha ' . $date->format('d-m-Y H'));

        foreach ($types as $type) {
            if ($total === 0) {
                return;
            }

            $forThisType = $this->rand($total);
            $this->saveEvents($forThisType, $type, $date);
        }
    }

    private function rand(int $max = 20): int
    {
        return mt_rand(0, $max);
    }

    private function saveEvents(int $forThisType, ActionType $type, \DateTimeImmutable $date): void
    {
        for ($i = 0; $i < $forThisType; $i++) {
            $action = new Action(
                $date,
                '1',
                '1',
                ChatType::createTelegam(),
                $type,
                ($type->equal(ActionType::productAdded())) ? 'Product ' . $this->rand() : ''
            );
            $this->actionRepository->saveAction($action);
        }
    }
}
