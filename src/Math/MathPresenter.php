<?php

namespace Src\Math;

use Money\Currencies\ISOCurrencies;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;
use NumberFormatter;

class MathPresenter
{
    public static function float(float $value, int $decimalDigits = 2): string
    {
        return number_format($value, $decimalDigits, ',', '.');
    }

    public static function money(float|Money $value): string
    {
        $formatter = new IntlMoneyFormatter(
            new NumberFormatter('pt_BR', NumberFormatter::CURRENCY),
            new ISOCurrencies()
        );;

        $value = $value instanceof Money
            ? $value
            : Money::BRL((int) ($value * 100));

        return $formatter->format($value);
    }

    public static function percentage(Percentage $value): string
    {
        $value = number_format($value->get(), 2, ',', '.');

        return "{$value} %";
    }
}
