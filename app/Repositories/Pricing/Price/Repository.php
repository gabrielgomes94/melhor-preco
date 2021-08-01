<?php

namespace App\Repositories\Pricing\Price;

use App\Models\Price;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;

class Repository
{
    private DecimalMoneyFormatter $moneyFormatter;

    public function __construct()
    {
        $this->moneyFormatter = new DecimalMoneyFormatter(new ISOCurrencies());
    }

    public function get(string $id): ?Price
    {
        return Price::find($id);
    }

    public function update(Price $model, Money $price, Money $profit): bool
    {
        $model->value = $this->formatValue($price);
        $model->profit = $this->formatValue($profit);

        return $model->save();
    }

    private function formatValue(Money $value): float
    {
        return (float) $this->moneyFormatter->format($value);
    }
}