<?php

namespace Src\Costs\Domain\UseCases;

use Src\Costs\Domain\Exceptions\UpdateCostsException;
use Src\Costs\Domain\UseCases\Contracts\UpdateCosts as UpdateCostsInterface;
use Src\Products\Domain\Exceptions\ProductNotFoundException;
use Src\Products\Domain\Events\ProductCostsUpdated;
use Src\Products\Domain\Models\Product\Data\Costs\Costs;
use Src\Products\Domain\Repositories\Contracts\ProductRepository;

class UpdateCosts implements UpdateCostsInterface
{
    public function __construct(
        private ProductRepository $productRepository
    )
    {
    }

    /**
     * @throws ProductNotFoundException
     * @throws UpdateCostsException
     */
    public function execute(string $sku, array $data): bool
    {
        if (!$products = $this->productRepository->getProductsAndVariations($sku)) {
            throw new ProductNotFoundException($sku);
        }

        foreach ($products as $product) {
            $result = $this->productRepository->updateCosts(
                $product,
                Costs::make($data, $product)
            );

            if (!$result) {
                throw new UpdateCostsException($sku);
            }

            event(new ProductCostsUpdated($product));
        }

        return true;
    }
}
