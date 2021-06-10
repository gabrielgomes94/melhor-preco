<?php

namespace Barrigudinha\Pricing\Data\Freight;

use Barrigudinha\Product\Product;
use Money\Money;

abstract class BaseFreight
{

    private Money $value;

    public function __construct(Product $product, Money $price)
    {
    }

    public function get(): Money
    {
        return $this->value;
    }

    abstract public function calculate(): Money;
}
