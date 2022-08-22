<?php

namespace Src\Products\Domain\Models\ValueObjects;

use Src\Products\Infrastructure\Laravel\Models\Product\Product;

class Composition
{
    private array $compositionProducts;

    /**
     * @param Product[] $compositionProducts
     */
    public function __construct(array $compositionProducts)
    {
        $this->fill($compositionProducts);
    }

    public function costs(): Costs
    {
        $purchasePrice = 0.0;
        $additionalCosts = 0.0;

        foreach ($this->compositionProducts as $product) {
            $costs = $product->getCosts();

            $purchasePrice += $costs->purchasePrice();
            $additionalCosts += $costs->additionalCosts();
            $taxes[] = $costs->taxICMS();
        }

        return new Costs($purchasePrice, $additionalCosts, max($taxes ?? [0.0]));
    }

    public function get(): array
    {
        return $this->compositionProducts;
    }

    public function getSkus(): array
    {
        foreach ($this->compositionProducts as $product) {
            $skuList[] = $product->getSku();
        }

        return $skuList ?? [];
    }

    public function hasCompositions(): bool
    {
        return count($this->compositionProducts) !== 0;
    }

    private function fill(array $compositionProducts): void
    {
        foreach ($compositionProducts as $product) {
            if ($product instanceof Product) {
                $products[] = $product;
            }
        }

        $this->compositionProducts = $products ?? [];
    }
}
