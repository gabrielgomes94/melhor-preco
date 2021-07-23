<?php

namespace App\Services\Product;

use App\Repositories\Pricing\Product\Updator;
use App\Repositories\Product\FinderDB;
use Barrigudinha\Pricing\Price\Services\CalculateProduct;

class RecalculateProfit
{
    private FinderDB $repository;
    private CalculateProduct $calculateProductService;
    private Updator $productUpdator;

    public function __construct(FinderDB $repository, CalculateProduct $calculateProductService, Updator $productUpdator)
    {
        $this->repository = $repository;
        $this->calculateProductService = $calculateProductService;
        $this->productUpdator = $productUpdator;
    }

    public function recalculateAll(): void
    {
        $products = $this->repository->all();

        foreach ($products as $product) {
            $product = $this->calculateProductService->recalculate($product);
            $model = $this->repository->getModel($product->sku());

            if (!$model) {
                continue;
            }

            $this->productUpdator->sync($product, $model);
        }
    }
}
