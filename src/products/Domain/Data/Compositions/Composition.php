<?php

namespace Src\Products\Domain\Data\Compositions;

use Src\Products\Domain\Data\Costs;
use Src\Products\Domain\Entities\Product;
use Src\Products\Domain\Entities\ProductsCollection;

class Composition
{
    private array $compositionProducts;

    public function __construct(array $compositionProducts)
    {
        $this->compositionProducts = $compositionProducts;
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
            $purchasePrice += $product->data()->getCosts()->purchasePrice();
            $additionalCosts += $product->data()->getCosts()->additionalCosts();
            $taxes[] = $product->data()->getCosts()->taxICMS();
        }

        return new Costs($purchasePrice, $additionalCosts, $taxICMS);
    }
}
