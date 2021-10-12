<?php

namespace Src\Prices\Domain\Price\Freight;

use Barrigudinha\Utils\Helpers;
use Money\Money;
use function config;

class Olist extends BaseFreight
{
    public const FREE_MIN_VALUE = 79.0;
    private array $rules;

    public function __construct($dimensions, Money $price)
    {
        $this->rules = [
            'free' => [
                'min' => Helpers::floatToMoney(self::FREE_MIN_VALUE),
            ],
        ];

        parent::__construct($dimensions, $price);
    }

    protected function calculate(): Money
    {
        if ($this->isFree()) {
            $weight = $this->getWeight();
            $freightTable = config('freight_tables.olist.free_freight_table');
            $discount_percentage = $this->getDiscountPercentage();
            $freight = $this->consultFreightTable($weight, $freightTable);

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
