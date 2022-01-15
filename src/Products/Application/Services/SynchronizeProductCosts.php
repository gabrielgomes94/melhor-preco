<?php

namespace Src\Products\Application\Services;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Src\Products\Domain\Models\Product\Data\Costs\Costs;
use Src\Products\Domain\Repositories\Contracts\ProductRepository;

class SynchronizeProductCosts
{
    private ProductRepository $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function sync(): void
    {
        $products = $this->repository->all();

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