<?php

namespace Src\Prices\Price\Domain\Transformer;

class Helpers
{
    public static function percentage(float $value): float
    {
        return $value / 100;
    }
}
