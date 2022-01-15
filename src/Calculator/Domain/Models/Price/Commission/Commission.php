<?php

namespace Src\Calculator\Domain\Models\Price\Commission;

use Money\Money;

class Commission
{
    protected Money $value;
    protected float $commissionRate = 0.0;

    public function __construct(Money $price, float $commissionRate)
    {
        $this->commissionRate = $commissionRate ?? 0.0;

        $this->fill($price, $commissionRate);
    }

    protected function fill(Money $price, float $commissionRate): void
    {
        $this->value = $price->multiply($commissionRate);
    }

    public function get(): Money
    {
        return $this->value;
    }

    public function getCommissionRate(): float
    {
        return $this->commissionRate;
    }
}
