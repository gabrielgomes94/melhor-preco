<?php

namespace Src\Math;

use Money\Money;

class MoneyCalculator
{
    public static function multiply(float $baseValue, float $multiplier): float
    {
        $value = MoneyTransformer::toMoney($baseValue);

        return MoneyTransformer::toFloat(
            $value->multiply((string) $multiplier)
        );
    }
}
