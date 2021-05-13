<?php

namespace Barrigudinha\Utils;

use Money\Money;

class Helpers
{
    public static function floatToMoney(float $value): Money
    {
        return Money::BRL((int) $value * 100);
    }

    public static function percentage(float $value): float
    {
        return $value / 100;
    }
}
