<?php

namespace Src\Products\Domain\Data\Compositions;

use Src\Products\Domain\Data\Costs;
use Src\Products\Domain\Entities\Product;
use Src\Products\Domain\Entities\ProductsCollection;

class Composition
{
    private ProductsCollection $compositionProducts;

    public function __construct(ProductsCollection $compositionProducts)
    {
        $this->compositionProducts = $compositionProducts;
    }

    public function hasCompositions(): bool
    {
        return $this->compositionProducts->count() !== 0;
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
}
