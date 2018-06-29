<?php

namespace Cartbot\Infrastructure\Repository;

use Doctrine\ORM\EntityRepository;
use Cartbot\Domain\Chat\ChatType;
use Cartbot\Domain\User\User;
use Cartbot\Domain\User\UserChat;
use Cartbot\Domain\User\UserChatNotRegisteredException;
use Cartbot\Domain\User\UserChatRepository;

class DoctrineUserChatRepository extends EntityRepository implements UserChatRepository
{
    public function getUserFromUserChatOrException(string $idUserInChat, ChatType $chatType): UserChat
    {
        $userChat = $this->findOneBy(['id' => $idUserInChat, 'type' => $chatType->name()]);
        if ($userChat == null) {
            throw new UserChatNotRegisteredException();
        }

        return $userChat;
    }

    public function saveUserChat(UserChat $userChat): void
    {
        $em = $this->getEntityManager();
        $em->persist($userChat->user());
        $em->persist($userChat);
        $em->flush();
    }
}
