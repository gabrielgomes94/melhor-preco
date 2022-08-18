<?php

namespace Src\Costs\Domain\UseCases;

use Src\Costs\Domain\Exceptions\UpdateCostsException;
use Src\Costs\Domain\UseCases\Contracts\UpdateCosts as UpdateCostsInterface;
use Src\Products\Domain\Exceptions\ProductNotFoundException;
use Src\Products\Domain\Events\ProductCostsUpdated;
use Src\Products\Domain\Models\Product\ValueObjects\Costs;
use Src\Products\Domain\Repositories\ProductRepository;

class UpdateCosts implements UpdateCostsInterface
{
    public function __construct(
        private ProductRepository $productRepository
    ) {
    }

    /**
     * @throws ProductNotFoundException
     * @throws UpdateCostsException
     */
    public function execute(string $sku, array $data, string $userId): bool
    {
        if (!$products = $this->productRepository->getProductsAndVariations($sku, $userId)) {
            throw new ProductNotFoundException($sku, $userId);
        }

        foreach ($products as $product) {
            $result = $this->productRepository->updateCosts(
                $product,
                Costs::make($data, $product),
                $userId
            );

            if (!$result) {
                throw new UpdateCostsException($sku);
            }

            event(new ProductCostsUpdated($product));
        }

        return true;
    }
}
