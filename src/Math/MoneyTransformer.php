<?php

namespace Src\Math;

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

    public static function toString(Money $value): string
    {
        $formatter = new DecimalMoneyFormatter(new ISOCurrencies());

        return $formatter->format($value);
    }
}