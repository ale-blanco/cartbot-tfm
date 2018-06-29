<?php

namespace CartbotPrivate\Application\CommandHandlers;

use CartbotPrivate\Domain\User\Email;
use CartbotPrivate\Domain\User\PasswordPlainText;
use Cartbot\Domain\Client\ClientRepository;
use CartbotPrivate\Domain\Services\PasswordEncoder;
use CartbotPrivate\Domain\User\UserClient;
use CartbotPrivate\Domain\User\UserClientRepository;
use CartbotPrivate\Domain\User\UserNameExistException;

class CreateUserClient
{
    private $clientRepository;
    private $userClientRepository;
    private $encoder;

    public function __construct(
        ClientRepository $clientRepository,
        UserClientRepository $userClientRepository,
        PasswordEncoder $encoder
    ) {
        $this->clientRepository = $clientRepository;
        $this->userClientRepository = $userClientRepository;
        $this->encoder = $encoder;
    }

    public function __invoke(string $idclient, string $username, Email $email, PasswordPlainText $password): void
    {
        $client = $this->clientRepository->findOneByIdOrException($idclient);
        $existUserClient = $this->userClientRepository->findOneByUserName($username);
        if ($existUserClient !== null) {
            throw new UserNameExistException();
        }

        $userClient = new UserClient($client, $username, $email, true);
        $passEncoded = $this->encoder->encode($userClient, $password->password());
        $userClient->setPassword($passEncoded);

        $this->userClientRepository->save($userClient);
    }
}
