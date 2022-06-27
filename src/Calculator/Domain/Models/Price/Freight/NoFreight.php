<?php

namespace Src\Calculator\Domain\Models\Price\Freight;

use Money\Money;
use Src\Products\Domain\Models\Product\ValueObjects\Dimensions;

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
