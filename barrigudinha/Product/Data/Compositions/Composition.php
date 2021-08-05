<?php

namespace Barrigudinha\Product\Data\Compositions;

use Barrigudinha\Product\Data\Costs;
use Barrigudinha\Product\Entities\Product;

class Composition
{
    /**
     * @var Product[]
     */
    private array $compositionProducts;

    private float $costs;

    public function __construct(array $compositionProducts)
    {
        $this->compositionProducts = $compositionProducts ?? [];
    }

    public function products(): array
    {
        return $this->compositionProducts;
    }

    public function hasCompositions(): bool
    {
        return !empty($this->compositionProducts);
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
