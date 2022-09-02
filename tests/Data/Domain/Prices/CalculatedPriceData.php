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
                MoneyTransformer::toMoney(550.0),
                MoneyTransformer::toMoney(20.0),
                Percentage::fromPercentage(12),
                Percentage::fromPercentage(18),
                Percentage::fromPercentage(5.45)
            ),
            MoneyTransformer::toMoney(899.9),
            MoneyTransformer::toMoney(100.0),
            MoneyTransformer::toMoney(0.0),
        );
    }

    public static function babyChair(): CalculatedPrice
    {
        return new CalculatedPrice(
            new CostPrice(
                MoneyTransformer::toMoney(380.0),
                MoneyTransformer::toMoney(0.0),
                Percentage::fromPercentage(12),
                Percentage::fromPercentage(18),
                Percentage::fromPercentage(5.45)
            ),
            MoneyTransformer::toMoney(699.9),
            MoneyTransformer::toMoney(100.0),
            MoneyTransformer::toMoney(0.0),
        );
    }

    public static function babyPacifier(): CalculatedPrice
    {
        return new CalculatedPrice(
            new CostPrice(
                MoneyTransformer::toMoney(6.75),
                MoneyTransformer::toMoney(0.0),
                Percentage::fromPercentage(12),
                Percentage::fromPercentage(18),
                Percentage::fromPercentage(5.45)
            ),
            MoneyTransformer::toMoney(19.9),
            MoneyTransformer::toMoney(2.25),
            MoneyTransformer::toMoney(0.0),
        );
    }
}
