<?php

namespace CartbotPrivate\Infrastructure\Commands;

use CartbotPrivate\Application\CommandHandlers\CreateUserClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use CartbotPrivate\Domain\User\Email;
use CartbotPrivate\Domain\User\PasswordPlainText;

class CreateUserClientCommand extends Command
{
    private $createUserClient;

    public function __construct(CreateUserClient $createUserClient)
    {
        $this->createUserClient = $createUserClient;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('userClient:create')
            ->setDescription('Crea, un nuevo usuario de cliente')
            ->addArgument('idClient', InputArgument::REQUIRED)
            ->addArgument('userName', InputArgument::REQUIRED)
            ->addArgument('email', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $idClient = $input->getArgument('idClient');
        $userName = $input->getArgument('userName');
        $email = new Email($input->getArgument('email'));

        $password = $this->giveMeAInput(
            'Indique la contraseña: ',
            'Debe indicar una contraseña',
            $input,
            $output
        );

        $repeatPassword = $this->giveMeAInput(
            'Repita la contraseña: ',
            'Debe repetir la contraseña',
            $input,
            $output
        );

        if ($password !== $repeatPassword) {
            $output->writeln('Las contraseñas no son iguales');
            return;
        }

        $this->createUserClient->__invoke($idClient, $userName, $email, new PasswordPlainText($password));
        $output->writeln('Usuario creado correctamente');
    }

    private function giveMeAInput(
        string $textQuestion,
        string $textIfNotRespond,
        InputInterface $input,
        OutputInterface $output
    ): string {
        $helper = $this->getHelper('question');
        $question = new Question($textQuestion);
        $question->setHidden(true);
        $question->setHiddenFallback(false);

        $inputText = $helper->ask($input, $output, $question);
        if (!$inputText) {
            throw new \Exception($textIfNotRespond);
        }

        return $inputText;
    }
}
