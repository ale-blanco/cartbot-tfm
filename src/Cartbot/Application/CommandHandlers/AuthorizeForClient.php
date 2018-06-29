<?php

namespace Cartbot\Application\CommandHandlers;

use Cartbot\Application\Commands\AuthorizeForClientComm;
use Cartbot\Domain\Services\EventBus;
use Cartbot\Domain\User\AuthorizeCorrectEvent;
use Cartbot\Domain\User\CustomerToken;
use Cartbot\Domain\User\User;
use Cartbot\Domain\User\UserChat;
use Cartbot\Domain\User\UserChatNotRegisteredException;
use Cartbot\Domain\User\UserChatRepository;
use Cartbot\Domain\User\UserRepository;
use Cartbot\Domain\User\UserStart;
use Cartbot\Domain\User\UserStartRepository;

class AuthorizeForClient
{
    private $userStartRepository;
    private $userChatRepository;
    private $userRepository;
    private $eventBus;

    public function __construct(
        UserStartRepository $userStartRepository,
        UserChatRepository $userChatRepository,
        UserRepository $userRepository,
        EventBus $eventBus
    ) {
        $this->userStartRepository = $userStartRepository;
        $this->userChatRepository = $userChatRepository;
        $this->userRepository = $userRepository;
        $this->eventBus = $eventBus;
    }

    public function __invoke(AuthorizeForClientComm $command): void
    {
        $userStart = $this->userStartRepository->findOneByCodeOrException($command->code());
        $userChat = $this->getUserChat($userStart);
        $customerToken = new CustomerToken($command->customerToken(), new \DateTimeImmutable());
        if ($userChat) {
            $userChat->user()->setCustomerToken($customerToken);
            $this->userRepository->saveUser($userChat->user());
            $this->sendEvent($userChat);
            return;
        }

        $user = $this->userRepository->getUserByNameAndClient($command->userName(), $userStart->client());
        if ($user === null) {
            $user = new User(null, $command->userName(), $customerToken, $userStart->client());
        } else {
            $user->setCustomerToken($customerToken);
        }
        $userChat = new UserChat($userStart->idUserChat(), $userStart->chatType(), $user);
        $this->userChatRepository->saveUserChat($userChat);
        $this->sendEvent($userChat);
    }

    private function getUserChat(UserStart $userStart): ?UserChat
    {
        try {
            return $this->userChatRepository
                ->getUserFromUserChatOrException($userStart->idUserChat(), $userStart->chatType());
        } catch (UserChatNotRegisteredException $ex) {
            return null;
        }
    }

    private function sendEvent(UserChat $userChat): void
    {
        $this->eventBus->handle(new AuthorizeCorrectEvent(
            $userChat->id(),
            $userChat->type(),
            $userChat->user()->id(),
            $userChat->user()->client()->id()
        ));
    }
}
