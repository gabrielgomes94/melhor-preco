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

    public function hasCompositions(): bool
    {
        return count($this->compositionProducts) !== 0;
    }

    public function getSkus(): array
    {
        foreach ($this->compositionProducts as $product) {
            $skuList[] = $product->sku();
        }

        return $skuList ?? [];
    }

    public function costs(): Costs
    {
        $purchasePrice = 0.0;
        $additionalCosts = 0.0;
        $taxICMS = 0.0;

        foreach ($this->compositionProducts as $product) {
            $purchasePrice += $product->costs()->purchasePrice();
            $additionalCosts += $product->costs()->additionalCosts();
            $taxes[] = $product->costs()->taxICMS();
        }

        return new Costs($purchasePrice, $additionalCosts, $taxICMS);
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
