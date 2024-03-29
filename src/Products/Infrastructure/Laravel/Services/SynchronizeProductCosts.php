<?php

namespace Src\Products\Infrastructure\Laravel\Services;

use Src\Products\Domain\Models\ValueObjects\Costs;
use Src\Products\Domain\Repositories\ProductRepository;
use Src\Products\Domain\Services\SyncProductCosts;
use Src\Users\Domain\Models\User;

class SynchronizeProductCosts implements SyncProductCosts
{
    private ProductRepository $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function sync(User $user): void
    {
        $products = $this->repository->all($user->getId());

        foreach ($products as $product) {
            $item = $product->getLastPurchaseItemsCosts();

            if (!$item) {
                continue;
            }

            $costs = new Costs(
                $item->getUnitCost(),
                $product->getCosts()->additionalCosts(),
                $item->getICMSPercentage(),
            );

            $this->repository->updateCosts($product, $costs, $user->getId());
        }
    }
}
