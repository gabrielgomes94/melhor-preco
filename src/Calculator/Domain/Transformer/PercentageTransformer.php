<?php

namespace Src\Calculator\Domain\Transformer;

class PercentageTransformer
{
    public static function toPercentage(float $value): float
    {
        return $value / 100;
    }
}
