<?php

namespace Tests\Data\Domain\Prices;

use Src\Math\MoneyTransformer;
use Src\Math\Percentage;
use Src\Prices\Domain\Models\Calculator\CalculatedPrice;
use Src\Prices\Domain\Models\Calculator\CostPrice;

class CalculatedPriceData
{
    public static function babyCarriage(): CalculatedPrice
    {
        return new CalculatedPrice(
            new CostPrice(
                550.0,
                20.0,
                Percentage::fromPercentage(12),
                Percentage::fromPercentage(18),
                Percentage::fromPercentage(5.45)
            ),
            899.9,
            100.0,
            0.0,
        );
    }

    public static function babyChair(): CalculatedPrice
    {
        return new CalculatedPrice(
            new CostPrice(
                380.0,
                0.0,
                Percentage::fromPercentage(12),
                Percentage::fromPercentage(18),
                Percentage::fromPercentage(5.45)
            ),
            699.9,
            100.0,
            0.0,
        );
    }

    public static function babyPacifier(): CalculatedPrice
    {
        return new CalculatedPrice(
            new CostPrice(
                6.75,
                0.0,
                Percentage::fromPercentage(12),
                Percentage::fromPercentage(18),
                Percentage::fromPercentage(5.45)
            ),
            19.9,
            2.25,
            0.0,
        );
    }
}
