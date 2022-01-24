<?php

namespace Src\Calculator\Domain\Transformer;

// @todo: substituir usos desse transformer
class PercentageTransformer
{
    public static function toPercentage(float $value): float
    {
        return $value / 100;
    }
}
