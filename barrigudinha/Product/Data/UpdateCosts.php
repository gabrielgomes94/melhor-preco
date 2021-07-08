<?php

namespace Barrigudinha\Product\Data;

class UpdateCosts
{
    private ?float $purchasePrice;
    private ?float $additionalCosts;
    private ?float $taxICMS;

    public function __construct(?float $purchasePrice = null, ?float $additionalCosts = null, ?float $taxICMS = null)
    {
        $this->purchasePrice = $purchasePrice;
        $this->additionalCosts = $additionalCosts;
        $this->taxICMS = $taxICMS;
    }

    public function additionalCosts(): float
    {
        return $this->additionalCosts ?? 0.0;
    }

    public function purchasePrice(): float
    {
        return $this->purchasePrice ?? 0.0;
    }

    public function taxICMS(): float
    {
        return $this->taxICMS ?? 0.0;
    }
}
