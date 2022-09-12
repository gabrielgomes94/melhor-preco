<?php

namespace Src\Math\Transformers;

use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;
use NumberFormatter;
use Src\Math\Percentage;

class NumberTransformer
{
    public static function toFloat(string|float $number): float
    {
        if (is_float($number)) {
            return $number;
        }

        return (float) str_replace(',', '.', $number);
    }

    public static function toText(float $value, int $decimalDigits = 2): string
    {
        return number_format($value, $decimalDigits, ',', '.');
    }

    public static function toMoney(null|float|Money $value): string
    {
        if (is_null($value)) {
            return '';
        }

        $value = $value instanceof Money
            ? $value
            : Money::BRL((int) ($value * 100));

        $formatter = new DecimalMoneyFormatter(new ISOCurrencies());
        $value = self::toText((float) $formatter->format($value));

        return "R$ $value";
    }

    public static function toPercentage(?Percentage $value): string
    {
        if (is_null($value)) {
            return '';
        }

        $value = self::toText($value->get());

        return "{$value} %";
    }
}
