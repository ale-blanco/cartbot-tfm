<?php

namespace CartbotPrivate\Infrastructure\Commands;

use CartbotPrivate\Application\CommandHandlers\CreateIndexActions;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateElasticIndexActionsCommand extends Command
{
    private $createIndexActions;

    public function __construct(CreateIndexActions $createIndexActions)
    {
        $this->createIndexActions = $createIndexActions;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('actions:createIndex')
            ->setDescription('Crea, si no existe, el indice para guardar las acciones')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->createIndexActions->__invoke();
    }
}
