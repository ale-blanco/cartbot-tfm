<?php

namespace Cartbot\Application\Services;

use Cartbot\Domain\Chat\ChatType;
use Cartbot\Domain\User\ITokenRepositoryFactory;
use Cartbot\Domain\User\UserChat;
use Cartbot\Domain\User\UserChatRepository;
use Cartbot\Domain\User\UserRepository;

class UserService implements IUserService
{
    private $userChatRepository;
    private $userRepositoryFactory;
    private $userRepository;

    public function __construct(
        UserChatRepository $userChatRepository,
        ITokenRepositoryFactory $userRepositoryFactory,
        UserRepository $userRepository
    ) {
        $this->userChatRepository = $userChatRepository;
        $this->userRepositoryFactory = $userRepositoryFactory;
        $this->userRepository = $userRepository;
    }

    public function getUserWithValidToken(string $idUserInChat, ChatType $chatType): UserChat
    {
        $userChat = $this->userChatRepository->getUserFromUserChatOrException($idUserInChat, $chatType);
        if ($userChat->user()->customerToken()->isValid()) {
            return $userChat;
        }

        $user = $userChat->user();
        $tokenRepository = $this->userRepositoryFactory->getRepository($userChat->user()->client()->id());
        $newCustomerToken = $tokenRepository->refreshToken($user->customerToken());
        $user->setCustomerToken($newCustomerToken);
        $this->userRepository->saveUser($user);
        return $userChat;
    }
}
