<?php

namespace Src\Math;

use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;
use NumberFormatter;

class MathPresenter
{
    public static function float(float $value, int $decimalDigits = 2): string
    {
        return number_format($value, $decimalDigits, ',', '.');
    }

    public static function money(null|float|Money $value): string
    {
        if (!$value) {
            return '';
        }

        $formatter = new DecimalMoneyFormatter(new ISOCurrencies());

        $value = $value instanceof Money
            ? $value
            : Money::BRL((int) ($value * 100));

        $value = self::numberFormat((float) $formatter->format($value));

        return "R$ $value";
    }

    public static function percentage(Percentage $value): string
    {
        $value = self::numberFormat($value->get());

        return "{$value} %";
    }

    public static function numberFormat(float $value): string
    {
        return number_format($value, 2, ',', '.');
    }
}
