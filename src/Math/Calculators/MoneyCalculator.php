<?php

namespace Src\Math\Calculators;

use Error;
use Money\Money;
use Src\Math\Transformers\MoneyTransformer;

class MoneyCalculator
{
    public static function subtract(...$values): float
    {
        $result = Money::BRL(0);

        foreach ($values as $key => $value) {
            if ($key == 0) {
                $result = self::getValue($value);

                continue;
            }

            $value = self::getValue($value);
            $result = $result->subtract($value);
        }

        return MoneyTransformer::toFloat($result);
    }

    public static function sum(...$values): float
    {
        $result = Money::BRL(0);

        foreach ($values as $key => $value) {
            if ($key == 0) {
                $result = self::getValue($value);

                continue;
            }

            $value = self::getValue($value);
            $result = $result->add($value);
        }

        return MoneyTransformer::toFloat($result);
    }

    public static function multiply(float $baseValue, float $multiplier): float
    {
        $value = MoneyTransformer::toMoney($baseValue);
        $value = $value->multiply((string) $multiplier);

        return MoneyTransformer::toFloat($value);
    }

    public static function divide(float $baseValue, float $divisor): float
    {
        $value = MoneyTransformer::toMoney($baseValue);
        $value = $value->divide((string) $divisor);

        return MoneyTransformer::toFloat($value);
    }

    private static function getValue(Money|float $value): Money
    {
        return is_float($value)
            ? MoneyTransformer::toMoney($value)
            : $value;
    }

//    private static function validate(Money|float $value): void
//    {}
}
