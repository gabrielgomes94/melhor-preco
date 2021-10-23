<?php

namespace Src\Prices\Price\Infrastructure\Repositories;

use Src\Prices\Price\Domain\Models\Price;
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

    // ToDo: receber commisao por parametro também
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
