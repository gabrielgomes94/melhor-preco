<?php

namespace Src\Prices\Calculator\Domain\Contracts\Transformer;

use Money\Money;

interface MoneyTransformer
{
    public static function toFloat(Money $value): float;

    public static function toMoney(float $value): Money;

    public static function toString(Money $value): string;
}
