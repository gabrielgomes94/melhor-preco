<?php

namespace Src\Products\Infrastructure\Laravel\Services;

use Src\Products\Domain\Models\Product\ValueObjects\Costs;
use Src\Products\Domain\Repositories\ProductRepository;
use Src\Users\Domain\Entities\User;

class UpdateProductCosts
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
            $item = $product->getLatestPurchaseItem();

            if (!$item) {
                continue;
            }

            $costs = new Costs(
                $item->getUnitCost(),
                0.0,
                $item->getICMSPercentage(),
            );
            $product->setCosts($costs);
            $product->save();
        }
    }
}
