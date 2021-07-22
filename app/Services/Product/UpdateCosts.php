<?php

namespace App\Services\Product;

use App\Factories\Product\Costs;
use App\Factories\Product\Product as ProductFactory;
use App\Models\Product as ProductModel;
use App\Repositories\Pricing\Product\Updator;
use App\Repositories\Product\FinderDB;
use Barrigudinha\Pricing\Price\Services\CalculateProduct;
use Barrigudinha\Product\Product;

class UpdateCosts
{
    private FinderDB $repository;
    private Updator $updator;
    private CalculateProduct $calculateProduct;

    public function __construct(FinderDB $repository, Updator $updator, CalculateProduct $calculateProduct)
    {
        $this->repository = $repository;
        $this->updator = $updator;
        $this->calculateProduct = $calculateProduct;
    }

    public function execute(string $sku, array $data): bool
    {
        if (!$productModel = $this->repository->getModel($sku)) {
            return false;
        }

        $product = $this->updateProduct($productModel, $data);

        if (!$this->updator->sync($product, $productModel)) {
            return false;
        }

        if ($product->hasVariations()) {
            $this->updateVariations($product, $data);
        }

        return true;
    }

    private function updateProduct(ProductModel $model, array $data): Product
    {
        $product = ProductFactory::buildFromModel($model);
        $costs = Costs::make($data, $product);
        $product->setCosts($costs);
        $product = $this->calculateProduct->recalculate($product);

        return $product;
    }

    private function updateVariations(Product $product, array $data): void
    {
        foreach ($product->variations()->get() as $variation) {
            $variationModel = $this->repository->getModel($variation->sku());
            $product = $this->updateProduct($variationModel, $data);

            $this->updator->sync($product, $variationModel);
        }
    }
}
