<?php

namespace Src\Products\Application\Services\Update;

use Src\Products\Application\Factories\Costs;
use Src\Products\Infrastructure\Repositories\GetDB;
use Src\Products\Infrastructure\Repositories\Updator as ProductUpdator;
use Src\Prices\Price\Application\Services\Exceptions\ProductNotFound;
use Src\Prices\Price\Application\Services\Exceptions\UpdateDBException;
use Src\Prices\Price\Application\Services\UpdateDB;
use Src\Prices\Calculator\Domain\Services\V1\CalculateProduct;
use Src\Products\Domain\Entities\Product;

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
     * @return \Src\Products\Domain\Entities\Product[]
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
