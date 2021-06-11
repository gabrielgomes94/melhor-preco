<?php

namespace Barrigudinha\Pricing\Data\Freight;

use Barrigudinha\Product\Product;
use Money\Money;

abstract class BaseFreight
{
    protected Money $freight;
    protected Money $price;

    public function __construct(Product $product, Money $price)
    {
        $this->price = $price;
    }

    public function get(): Money
    {
        return $this->freight;
    }
}
