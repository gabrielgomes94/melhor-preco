<?php

namespace App\Services\Product;

use App\Factories\Product\Product as ProductFactory;
use App\Repositories\Pricing\Product\Updator;
use App\Repositories\Product\FinderDB;
use Barrigudinha\Pricing\Services\PriceCalculator\ProductCalculator;
use Barrigudinha\Product\Data\Costs;
use Barrigudinha\Product\Product;

class UpdateCosts
{
    private FinderDB $repository;
    private Updator $updator;
    private ProductCalculator $calculator;

    public function __construct(FinderDB $repository, Updator $updator, ProductCalculator $calculator)
    {
        $this->repository = $repository;
        $this->updator = $updator;
        $this->calculator = $calculator;
    }

    public function execute(string $sku, array $data): bool
    {
        if (!$productModel = $this->repository->getModel($sku)) {
            return false;
        }

        $product = ProductFactory::buildFromModel($productModel);

        $costs = $this->makeCosts($product, $data);
        $product->setCosts($costs);
        foreach ($product->posts() as $post) {
            $postPriced = $this->calculator->single($product, $post->store()->slug());
            $post->setProfit($postPriced->price()->profit());
        }

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

            foreach ($product->posts() as $post) {
                $postPriced = $this->calculator->single($product, $post->store()->slug());
                $post->setProfit($postPriced->price()->profit());
            }
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
