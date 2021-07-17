<?php

namespace App\Services\Product;

use App\Factories\Product\Product as ProductFactory;
use App\Repositories\Pricing\Product\Updator;
use App\Repositories\Product\FinderDB;
use Barrigudinha\Product\Data\Costs;
use Barrigudinha\Product\Product;

class UpdateCosts
{
    private FinderDB $repository;
    private Updator $updator;

    public function __construct(FinderDB $repository, Updator $updator)
    {
        $this->repository = $repository;
        $this->updator = $updator;
    }

    public function execute(string $sku, array $data): bool
    {
        if (!$productModel = $this->repository->getModel($sku)) {
            return false;
        }
//        dd($productModel);
        $product = ProductFactory::buildFromModel($productModel);

        $costs = $this->makeCosts($product, $data);
        $product->setCosts($costs);

        if (!$this->updator->sync($product, $productModel)) {
            return false;
        }

        if ($product->hasVariations()) {
            $this->updateVariations($product, $costs);
        }

        return true;
    }

    private function updateVariations(Product $product, Costs $costs): void
    {
        foreach ($product->variations()->get() as $variation) {
            $variationModel = $this->repository->getModel($variation->sku());
            $product = ProductFactory::buildFromModel($variationModel);
            $product->setCosts($costs);
            $this->updator->sync($product, $variationModel);
        }
    }

    private function makeCosts(Product $product, array $data)
    {
        return new Costs(
            purchasePrice: $data['purchasePrice'] ?? $product->costs()->purchasePrice(),
            additionalCosts: $data['additionalCosts'] ?? $product->costs()->additionalCosts(),
            taxICMS: $data['taxICMS'] ?? $product->costs()->taxICMS(),
        );
    }
}
