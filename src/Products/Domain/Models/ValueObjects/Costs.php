<?php

namespace Src\Products\Domain\Models\ValueObjects;

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
