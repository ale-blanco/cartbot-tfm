<?php

namespace Cartbot\Application\EventHandlers;

use Cartbot\Application\Services\CreateUrlForAuth;
use Cartbot\Application\Services\TextListCommands;
use Cartbot\Domain\Chat\ChatType;
use Cartbot\Domain\Chat\ISenderChatFactory;
use Cartbot\Domain\User\StartEvent;
use Cartbot\Domain\User\UserChatNotRegisteredException;
use Cartbot\Domain\User\UserChatRepository;

class StartResponse extends AbstractResponse
{
    private $createCodeForAuth;
    private $userChatRepository;

    public function __construct(
        ISenderChatFactory $senderFactory,
        CreateUrlForAuth $createCodeForAuth,
        UserChatRepository $userChatRepository
    ) {
        parent::__construct($senderFactory);
        $this->createCodeForAuth = $createCodeForAuth;
        $this->userChatRepository = $userChatRepository;
    }

    public function __invoke(StartEvent $event): void
    {
        $text = 'Hola, bienvenido';
        if (!$this->isUserRegistered($event->idUserChat(), $event->chatType())) {
            $urlAuth = $this->createCodeForAuth->getCode($event->idUserChat(), $event->idClient(), $event->chatType());
            $text = $this->getResponse($urlAuth);
        }

        $this->senderFactory
            ->getSender($event->chatType())
            ->send($event->idUserChat(), $text);
    }

    private function getResponse(string $urlAuth): string
    {
        return 'Hola,' . PHP_EOL
            . 'Para poder usar el servicio debes autorizarme en Ulabox, ve a esta url:' . PHP_EOL
            . $urlAuth . PHP_EOL
            . PHP_EOL
            . TextListCommands::getTextListCommands();
    }

    private function isUserRegistered(string $idUserChat, ChatType $type): bool
    {
        try {
            $this->userChatRepository->getUserFromUserChatOrException($idUserChat, $type);
            return true;
        } catch (UserChatNotRegisteredException $ex) {
            return false;
        }
    }
}
