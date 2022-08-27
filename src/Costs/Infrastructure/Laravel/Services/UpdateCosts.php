<?php

namespace Src\Costs\Infrastructure\Laravel\Services;

use Src\Costs\Domain\Exceptions\UpdateCostsException;
use Src\Costs\Domain\Services\UpdateCosts as UpdateCostsInterface;
use Src\Products\Domain\Exceptions\ProductNotFoundException;
use Src\Products\Domain\Events\ProductCostsUpdated;
use Src\Products\Domain\Models\ValueObjects\Costs;
use Src\Products\Domain\Repositories\ProductRepository;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;

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
                $this->getCosts($data, $product),
                $userId
            );

            if (!$result) {
                throw new UpdateCostsException($sku);
            }

            event(new ProductCostsUpdated($product));
        }

        return true;
    }

    private function getCosts(array $data, Product $product): Costs
    {
        $costs = $product->getCosts();

        return new Costs(
            purchasePrice: $data['purchasePrice'] ?? $costs->purchasePrice(),
            additionalCosts: $data['additionalCosts'] ?? $costs->additionalCosts(),
            taxICMS: $data['taxICMS'] ?? $costs->taxICMS(),
        );
    }
}
