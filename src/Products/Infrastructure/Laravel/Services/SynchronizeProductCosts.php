<?php

namespace Src\Products\Infrastructure\Laravel\Services;

use Src\Products\Domain\Models\Product\ValueObjects\Costs;
use Src\Products\Domain\Repositories\ProductRepository;
use Src\Products\Domain\Services\SyncProductCosts;
use Src\Users\Domain\Models\User;

//@todo: talvez seja interessante chamar esse serviço apenas no fluxo de sincronização de notas fiscais de entrada
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
            $item = $product->getLatestPurchaseItem();

            if (!$item) {
                continue;
            }

            $costs = new Costs(
                $item->getUnitCost(),
                $product->getCosts()->additionalCosts(),
                $item->getICMSPercentage(),
            );

//            dd($item);
//
            $this->repository->updateCosts($product, $costs, $user->getId());
//            $product->setCosts($costs);
//            $product->save();
        }
    }
}
