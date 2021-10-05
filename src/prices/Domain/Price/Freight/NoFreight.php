<?php

namespace Src\Prices\Domain\Price\Freight;

use Barrigudinha\Product\Data\Dimensions;
use Money\Money;

class NoFreight extends BaseFreight
{
    public function __construct(Dimensions $dimensions, Money $price)
    {
        parent::__construct($dimensions, $price);
    }

    protected function calculate(): Money
    {
        return Money::BRL(0);
    }
}
