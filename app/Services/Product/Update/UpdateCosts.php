<?php

namespace App\Services\Product\Update;

use App\Factories\Product\Costs;
use App\Repositories\Product\FinderDB;
use App\Repositories\Product\Updator as ProductUpdator;
use App\Services\Pricing\UpdatePrice;
use Barrigudinha\Pricing\Price\Services\CalculateProduct;
use Barrigudinha\Product\Product;

class UpdateCosts
{
    private CalculateProduct $calculateProduct;
    private FinderDB $repository;
    private ProductUpdator $productUpdator;
    private UpdatePrice $updatePriceService;

    public function __construct(FinderDB $repository, ProductUpdator $productUpdator, CalculateProduct $calculateProduct, UpdatePrice $updatePriceService)
    {
        $this->repository = $repository;
        $this->productUpdator = $productUpdator;
        $this->calculateProduct = $calculateProduct;
        $this->updatePriceService = $updatePriceService;
    }

    public function execute(string $sku, array $data): bool
    {
        if (!$product = $this->repository->get($sku)) {
            return false;
        }

        $products = $this->getProducts($product);

        foreach ($products as $product) {
            $costs = Costs::make($data, $product);
            $product->setCosts($costs);
            $product = $this->calculateProduct->recalculate($product);

            $this->productUpdator->updateCosts($product);

            foreach ($product->posts() as $post) {
                $this->updatePriceService->execute($product->sku(), $post);
            }
        }

        return true;
    }
    /**
     * @return Product[]
     */
    private function getProducts(Product $product): array
    {
        $products[] = $product;

        foreach ($product->variations()->get() as $variation) {
            $products[] = $variation;
        }

        return $products;
    }
}
