<?php

namespace Src\Prices\Calculator\Domain\Models\Price\Freight;

use Src\Prices\Calculator\Domain\Transformer\PercentageTransformer;
use Money\Money;
use Src\Prices\Calculator\Domain\Transformer\MoneyTransformer;
use function config;

class Olist extends BaseFreight
{
    public const FREE_MIN_VALUE = 79.0;
    private array $rules;

    public function __construct($dimensions, Money $price)
    {
        $this->rules = [
            'free' => [
                'min' => MoneyTransformer::toMoney(self::FREE_MIN_VALUE),
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

        return MoneyTransformer::toMoney($customerFreightValue);
    }

    private function isFree(): bool
    {
        return $this->price->greaterThanOrEqual($this->rules['free']['min']);
    }

    private function getDiscountPercentage(): float
    {
        $discount = config('freight_tables.olist.free_freight_discount');

        return PercentageTransformer::toPercentage($discount ?? 0.0);
    }
}
