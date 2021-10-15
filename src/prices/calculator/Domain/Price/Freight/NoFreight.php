<?php

namespace Src\Prices\Calculator\Domain\Price\Freight;

use Src\Prices\Calculator\Domain\Price\Freight\BaseFreight;
use Src\Products\Domain\Data\Dimensions;
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
