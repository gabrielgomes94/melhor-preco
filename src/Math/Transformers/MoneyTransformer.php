<?php

namespace Src\Math\Transformers;

use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;

class MoneyTransformer
{
    public static function toFloat(Money $value): float
    {
        $formatter = new DecimalMoneyFormatter(new ISOCurrencies());

        return (float) $formatter->format($value);
    }

    public static function toMoney(float $value): Money
    {
        return Money::BRL((int) ($value * 100));
    }

    public static function toText(Money $value): string
    {
        return NumberTransformer::toMoney($value);
    }
}
