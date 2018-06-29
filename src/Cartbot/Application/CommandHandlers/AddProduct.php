<?php

namespace Cartbot\Application\CommandHandlers;

use Cartbot\Application\Commands\AddProductComm;
use Cartbot\Application\Services\IUserService;
use Cartbot\Domain\Cart\ICartRepositoryFactory;
use Cartbot\Domain\Product\AddProductEvent;
use Cartbot\Domain\Product\IProductRepositoryFactory;
use Cartbot\Domain\Product\NotFindedProductException;
use Cartbot\Domain\Services\EventBus;

class AddProduct
{
    private $productRepositoryFactory;
    private $cartRepositoryFactory;
    private $eventBus;
    private $userService;

    public function __construct(
        IUserService $userService,
        IProductRepositoryFactory $productRepositoryFactory,
        ICartRepositoryFactory $cartRepositoryFactory,
        EventBus $eventBus
    ) {
        $this->userService = $userService;
        $this->productRepositoryFactory = $productRepositoryFactory;
        $this->cartRepositoryFactory = $cartRepositoryFactory;
        $this->eventBus = $eventBus;
    }

    public function __invoke(AddProductComm $command): void
    {
        $userChat = $this->userService->getUserWithValidToken($command->idUserInChat(), $command->chatType());
        $idClient = $userChat->user()->client()->id();
        $productRepository = $this->productRepositoryFactory->getRepository($idClient);
        $listProducts = $productRepository->searchProduct($command->queryProduct());
        if ($listProducts->count() === 0) {
            throw new NotFindedProductException();
        }

        $product = $listProducts->get(0);
        $cartRepository = $this->cartRepositoryFactory->getRepository($idClient);
        $cartRepository->addProduct($product, $userChat->user()->customerToken(), 1);

        $this->eventBus->handle(new AddProductEvent(
            $userChat->id(),
            $userChat->type(),
            $userChat->user()->id(),
            $userChat->user()->client()->id(),
            $product->name()
        ));
    }
}
