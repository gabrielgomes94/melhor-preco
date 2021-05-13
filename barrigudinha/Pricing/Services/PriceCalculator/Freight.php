<?php

namespace Barrigudinha\Pricing\Services\PriceCalculator;

use Barrigudinha\Pricing\Data\Product;
use Money\Money;
use Barrigudinha\Product\Dimensions;

class Freight
{
    private Money $freight;

    public function __construct(Product $product)
    {
        $this->freight = $this->calculate($product->dimensions());
    }

    public function get(): Money
    {
        return $this->freight;
    }

    private function calculate(Dimensions $dimensions): Money
    {
        $cubicWeight = $dimensions->cubicWeight();
        $freightTable = config('freight_tables.b2w');

        foreach($freightTable as $row) {
            if ($row['interval'][0] <= $cubicWeight && $cubicWeight <= $row['interval'][1]) {
                $freight = Money::BRL($row['value'] * 100);
            }
        }

        return $freight ?? Money::BRL(0);
    }
}
