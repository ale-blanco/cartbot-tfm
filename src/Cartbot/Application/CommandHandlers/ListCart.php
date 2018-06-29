<?php

namespace Cartbot\Application\CommandHandlers;

use Cartbot\Application\Commands\ListCartComm;
use Cartbot\Application\Services\IUserService;
use Cartbot\Domain\Cart\ICartRepositoryFactory;
use Cartbot\Domain\Cart\ListCartEvent;
use Cartbot\Domain\Services\EventBus;

class ListCart
{
    private $cartRepositoryFactory;
    private $eventBus;
    private $userService;

    public function __construct(
        IUserService $userService,
        ICartRepositoryFactory $cartRepositoryFactory,
        EventBus $eventBus
    ) {
        $this->userService = $userService;
        $this->cartRepositoryFactory = $cartRepositoryFactory;
        $this->eventBus = $eventBus;
    }

    public function __invoke(ListCartComm $command): void
    {
        $userChat = $this->userService->getUserWithValidToken($command->idUserInChat(), $command->chatType());
        $cartRepository = $this->cartRepositoryFactory->getRepository($userChat->user()->client()->id());
        $cart = $cartRepository->listCart($userChat->user()->customerToken());
        $this->eventBus->handle(new ListCartEvent(
            $userChat->id(),
            $userChat->type(),
            $userChat->user()->id(),
            $userChat->user()->client()->id(),
            $cart
        ));
    }
}
