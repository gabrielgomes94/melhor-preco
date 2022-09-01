<?php

namespace Src\Math;

class ProfitMargin
{
    public static function calculate(float $value, float $profit): Percentage
    {
        if (!$value) {
            return Percentage::fromPercentage(0);
        }

        return Percentage::fromFraction($profit / $value);
    }
}
