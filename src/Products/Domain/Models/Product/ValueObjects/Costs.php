<?php

namespace Src\Products\Domain\Models\Product\ValueObjects;

use Src\Products\Infrastructure\Laravel\Models\Product\Product;

class Costs
{
    private float $purchasePrice;
    private float $additionalCosts;
    private float $taxICMS;

    public function __construct(?float $purchasePrice = null, ?float $additionalCosts = null, ?float $taxICMS = null)
    {
        $this->purchasePrice = $purchasePrice ?? 0.0;
        $this->additionalCosts = $additionalCosts ?? 0.0;
        $this->taxICMS = $taxICMS ?? 0.0;
    }

    public static function make(array $data, Product $product): self
    {
        $costs = $product->getCosts();

        return new self(
            purchasePrice: $data['purchasePrice'] ?? $costs->purchasePrice(),
            additionalCosts: $data['additionalCosts'] ?? $costs->additionalCosts(),
            taxICMS: $data['taxICMS'] ?? $costs->taxICMS(),
        );
    }

    public function additionalCosts(): float
    {
        return $this->additionalCosts;
    }

    public function purchasePrice(): float
    {
        return $this->purchasePrice;
    }

    public function taxICMS(): float
    {
        return $this->taxICMS;
    }
}
