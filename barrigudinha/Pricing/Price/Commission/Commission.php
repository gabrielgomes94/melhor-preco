<?php

namespace Barrigudinha\Pricing\Price\Commission;

use Money\Money;

class Commission
{
    protected Money $value;

    public function __construct(Money $price, float $commissionRate)
    {
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
}
