<?php

namespace App\Presenters\Pricing\Show;

use App\Models\Price as PriceModel;

class Price
{
    private const CSS_TEXT_GREEN = 'text-success';
    private const CSS_TEXT_RED = 'text-danger';

    public string $store;
    public float $value;
    public float $profit;

    public function __construct(PriceModel $price)
    {
        $this->store = $price->store;
        $this->value = $price->value;
        $this->profit = $price->profit;
    }

    public function profitMargin(): string
    {
        if ($this->profit <= 0) {
            return '--- %';
        }

        if (0.0 === $this->value) {
            return '--- %';
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

    public function color(): string
    {
        return $this->profit >= 0
            ? self::CSS_TEXT_GREEN
            : self::CSS_TEXT_RED;
    }
}
