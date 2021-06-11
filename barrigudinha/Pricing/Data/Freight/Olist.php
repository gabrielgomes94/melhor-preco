<?php

namespace Barrigudinha\Pricing\Data\Freight;

use Barrigudinha\Product\Product;
use Barrigudinha\Utils\Helpers;
use Money\Money;

class Olist extends BaseFreight
{
    public const FREE_MIN_VALUE = 79.0;
    private array $rules;

    public function __construct(Product $product, Money $price)
    {
        parent::__construct($product, $price);

        $this->rules = [
            'free' => [
                'min' => Helpers::floatToMoney(self::FREE_MIN_VALUE),
            ],
        ];

        $this->freight = $this->calculate($product);
    }

    private function calculate(Product $product): Money
    {
        if ($this->isFree()) {
            $cubicWeight = $product->dimensions()->cubicWeight();

            if ($cubicWeight <= 5.0) {
                $weight = $cubicWeight;
            } else {
                $weight = ($cubicWeight > $product->weight()) ?
                    $cubicWeight :
                    $product->weight();
            }

            $freightTable = config('freight_tables.olist.free_freight_table');
            $discount_percentage = $this->getDiscountPercentage();

            foreach ($freightTable as $row) {
                if ($row['interval'][0] <= $weight && $weight <= $row['interval'][1]) {
                    $freight = Helpers::floatToMoney($row['value']);
                }
            }

            return $freight->multiply(1 - $discount_percentage) ?? Money::BRL(0);
        }

        $customerFreightValue = config('freight_tables.olist.customer_freight_value');

        return Helpers::floatToMoney($customerFreightValue);
    }

    private function isFree(): bool
    {
        return $this->price->greaterThanOrEqual($this->rules['free']['min']);
    }

    private function getDiscountPercentage(): float
    {
        $discount = config('freight_tables.olist.free_freight_discount');

        return Helpers::percentage($discount ?? 0.0);
    }
}
