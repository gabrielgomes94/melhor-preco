<?php

namespace Src\Prices\Calculator\Domain\Transformer;

use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;
use Src\Prices\Calculator\Domain\Transformer\Contracts\MoneyTransformer as MoneyTransformerInterface;

// @todo: Move this class to Math context and use it
class MoneyTransformer implements MoneyTransformerInterface
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
