<?php

namespace Src\Prices\Calculator\Domain\Price\Freight;

use Barrigudinha\Utils\Helpers;
use Money\Money;
use Src\Products\Domain\Product\Models\Data\Dimensions\Dimensions;
use function config;

class B2W extends BaseFreight
{
    public const SUBSIDY_MIN_VALUE = 40.0;
    public const SUBSIDY_MAX_VALUE = 79.99;
    public const FREE_MIN_VALUE = 80.0;
    private const SELLER_INDEX_POINTS = 42;

    public function __construct(Dimensions $dimensions, Money $price)
    {
        $this->rules = [
            'subsidy' => [
                'min' => Helpers::floatToMoney(self::SUBSIDY_MIN_VALUE),
                'max' => Helpers::floatToMoney(self::SUBSIDY_MAX_VALUE),
            ],
            'free' => [
                'min' => Helpers::floatToMoney(self::FREE_MIN_VALUE),
            ],
        ];

        parent::__construct($dimensions, $price);
    }

    protected function calculate(): Money
    {
        $cubicWeight = $this->dimensions->cubicWeight();

        if ($this->isFixed()) {
            return Money::BRL(500);
        }

        if ($this->isSubsidy()) {
            $freightValue = config('freight_tables.b2w.subsidy_freight.value');
            $discount_percentage = $this->getDiscountPercentage();
            $freight = Helpers::floatToMoney($freightValue);

            return $freight->multiply(1 - $discount_percentage);
        }

        if ($this->isFree()) {
            $freightTable = config('freight_tables.b2w.free_freight_table');
            $discount_percentage = $this->getDiscountPercentage();
            $freight = $this->consultFreightTable($cubicWeight, $freightTable);

            return $freight->multiply(1 - $discount_percentage) ?? Money::BRL(0);
        }

        return Money::BRL(0);
    }

    private function isFixed(): bool
    {
        return $this->price->lessThan($this->rules['subsidy']['min']);
    }

    private function isSubsidy(): bool
    {
        return $this->price->greaterThanOrEqual($this->rules['subsidy']['min'])
            && $this->price->lessThanOrEqual($this->rules['subsidy']['max']);
    }

    private function isFree(): bool
    {
        return $this->price->greaterThanOrEqual($this->rules['free']['min']);
    }

    private function getDiscountPercentage(): float
    {
        $sellerIndexTable = config('freight_tables.b2w.seller_index');

        foreach ($sellerIndexTable as $row) {
            if ($row['interval'][0] <= self::SELLER_INDEX_POINTS && self::SELLER_INDEX_POINTS <= $row['interval'][1]) {
                $discount = $row['discount_percentage'];

                break;
            }
        }

        return Helpers::percentage($discount ?? 0.0);
    }
}
