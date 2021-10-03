<?php

namespace App\Services\Product\Update;

use App\Factories\Product\Costs;
use App\Repositories\Product\GetDB;
use App\Repositories\Product\Updator as ProductUpdator;
use Src\Prices\Application\Services\UpdatePrice\Exceptions\ProductNotFound;
use Src\Prices\Application\Services\UpdatePrice\Exceptions\UpdateDBException;
use Src\Prices\Application\Services\UpdatePrice\UpdateDB;
use Barrigudinha\Pricing\Price\Services\CalculateProduct;
use Barrigudinha\Product\Entities\Product;

class UpdateCosts
{
    private CalculateProduct $calculateProduct;
    private GetDB $repository;
    private ProductUpdator $productUpdator;
    private UpdateDB $updatePriceService;

    public function __construct(GetDB $repository, ProductUpdator $productUpdator, CalculateProduct $calculateProduct, UpdateDB $updatePriceService)
    {
        $this->repository = $repository;
        $this->productUpdator = $productUpdator;
        $this->calculateProduct = $calculateProduct;
        $this->updatePriceService = $updatePriceService;
    }

    public function execute(string $sku, array $data): bool
    {
        if (!$product = $this->repository->get($sku)) {
            throw new ProductNotFound();
        }

        $products = $this->getProducts($product);

        foreach ($products as $product) {
            $costs = Costs::make($data, $product);
            $product->setCosts($costs);
            $product = $this->calculateProduct->recalculate($product);

            $this->productUpdator->updateCosts($product);

            foreach ($product->posts() as $post) {
                $result = $this->updatePriceService->execute($post);

                if (!$result) {
                    throw new UpdateDBException();
                }
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
