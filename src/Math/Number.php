<?php

namespace Src\Math;

class Number
{
    public static function transform(string|float $number): float
    {
        if (is_float($number)) {
            return $number;
        }

        return (float) str_replace(',', '.', $number);
    }
}
