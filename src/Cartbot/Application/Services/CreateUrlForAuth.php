<?php

namespace Cartbot\Application\Services;

use Cartbot\Domain\Chat\ChatType;
use Cartbot\Domain\Client\ClientRepository;
use Cartbot\Domain\User\UserStart;
use Cartbot\Domain\User\UserStartRepository;

class CreateUrlForAuth
{
    private $userStartRepository;
    private $clientRepository;
    private $saltForAuthCode;

    public function __construct(
        UserStartRepository $userStartRepository,
        ClientRepository $clientRepository,
        string $saltForAuthCode
    ) {
        $this->userStartRepository = $userStartRepository;
        $this->clientRepository = $clientRepository;
        $this->saltForAuthCode = $saltForAuthCode;
    }

    public function getCode(string $idChat, string $idClient, ChatType $chatType): string
    {
        $client = $this->clientRepository->findOneByIdOrException($idClient);
        $code = $this->generateCode($idChat, $idClient, $chatType);
        if ($this->userStartRepository->findOneByCode($code) !== null) {
            return $this->getUrl($client->urlAuth(), $code, $client->idClientAuth());
        }

        $userStart = new UserStart($code, $client, $idChat, $chatType);
        $this->userStartRepository->save($userStart);
        return $this->getUrl($client->urlAuth(), $code, $client->idClientAuth());
    }

    private function generateCode(string $idChat, string $idClient, ChatType $chatType): string
    {
        return sha1($this->saltForAuthCode . $idClient . $idChat . $chatType->name());
    }

    private function getUrl(string $baseUrl, string $code, string $clientAuth): string
    {
        return $baseUrl . '?code=' . $code . '&client=' . $clientAuth;
    }
}
