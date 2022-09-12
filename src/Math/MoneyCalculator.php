<?php

namespace Src\Math;

use Error;
use Money\Money;

class MoneyCalculator
{
    public static function subtract(...$values): float
    {
        $baseValue = $values[0];
        $result = Money::BRL(0);

        foreach ($values as $key => $value) {
            self::validate($value);

            if ($key == 0) {
                $result = is_float($value) ? MoneyTransformer::toMoney($value) : $value;

                continue;
            }
//            if (!$value instanceof Money && !is_float($value)) {
//                throw new Error('Value must be type Money or float');
//            }

            if (is_float($value)) {
                $value = MoneyTransformer::toMoney($value);
            }

            $result = $result->subtract($value);
        }

        return MoneyTransformer::toFloat($result);
    }

    public static function sum(...$values): float
    {
        $result = Money::BRL(0);

        foreach ($values as $value) {
//            if (!$value instanceof Money && !is_float($value)) {
//                throw new Error('Value must be type Money or float');
//            }
            self::validate($value);

            if (is_float($value)) {
                $value = MoneyTransformer::toMoney($value);
            }

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

    private static function validate(Money|float $value): void
    {}
}
