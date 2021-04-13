<?php

namespace App\Presenters\Pricing\Show;

use App\Models\Price as PriceModel;

class Price
{
    public string $store;
    public float $value;
    public float $profit;

    public function __construct(PriceModel $price)
    {
        $this->store = $price->store;
        $this->value = $price->value;
        $this->profit = $price->profit;
//        $this->profit = rand(8000, 20000) / 100.0;
    }

    public function profitMargin(): string
    {
        if (0.0 === $this->value) {
            return '';
        }

        $profitMargin = ($this->profit / $this->value) * 100;
        $profitMargin = round($profitMargin, 2);

        return $profitMargin . '%';
    }

    public function value(): string
    {
        return 'R$ ' . (float) $this->value;
    }

    public function profit(): string
    {
        return 'R$ ' . (float) $this->profit;
    }
}
