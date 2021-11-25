<?php

namespace Src\Prices\Calculator\Domain\Models\Price\Freight;

use Money\Money;
use Src\Prices\Calculator\Domain\Transformer\MoneyTransformer;
use Src\Products\Domain\Models\Product\Data\Dimensions\Dimensions;

abstract class BaseFreight
{
    protected Money $freight;
    protected Money $price;
    protected Dimensions $dimensions;

    public function __construct(Dimensions $dimensions, Money $price)
    {
        $this->price = $price;
        $this->dimensions = $dimensions;
        $this->freight = $this->calculate();
    }

    abstract protected function calculate(): Money;

    public function get(): Money
    {
        return $this->freight;
    }

    protected function getWeight(): float
    {
        $cubicWeight = $this->dimensions->cubicWeight();

        if ($cubicWeight <= 5.0) {
            return $this->dimensions->weight();
        }

        return ($cubicWeight > $this->dimensions->weight())
            ? $cubicWeight
            : $this->dimensions->weight();
    }

    protected function consultFreightTable(float $weight, array $freightTable = []): Money
    {
        foreach ($freightTable as $row) {
            if ($row['interval'][0] <= $weight && $weight <= $row['interval'][1]) {
                $freight = MoneyTransformer::toMoney($row['value']);
            }
        }

        return $freight ?? Money::BRL(0);
    }
}
