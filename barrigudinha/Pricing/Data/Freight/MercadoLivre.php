<?php

namespace Barrigudinha\Pricing\Data\Freight;

use Barrigudinha\Product\Entities\Product;
use Barrigudinha\Utils\Helpers;
use Money\Money;

class MercadoLivre extends BaseFreight
{
    public const FREE_MIN_VALUE = 79.0;

    public function __construct(Product $product, Money $price)
    {
        parent::__construct($product, $price);

        $this->freight = $this->calculate($product);
    }

    private function calculate(Product $product): Money
    {
        $cubicWeight = $product->dimensions()->cubicWeight();

        if ($cubicWeight <= 5.0) {
            $weight = $cubicWeight;
        } else {
            $weight = ($cubicWeight > $product->dimensions()->weight()) ?
                $cubicWeight :
                $product->dimensions()->weight();
        }

        $freeMinValue = Helpers::floatToMoney(self::FREE_MIN_VALUE);
        if ($this->price->lessThanOrEqual($freeMinValue)) {
            $freightTable = config('freight_tables.mercado_livre.free_freight_table_1');
        } else {
            $freightTable = config('freight_tables.mercado_livre.free_freight_table_2');
        }

        foreach ($freightTable as $row) {
            if ($row['interval'][0] <= $weight && $weight <= $row['interval'][1]) {
                $freight = Helpers::floatToMoney($row['value']);
            }
        }

        return $freight ?? Money::BRL(0);
    }
}
