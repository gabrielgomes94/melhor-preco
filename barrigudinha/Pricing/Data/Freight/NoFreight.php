<?php

namespace Barrigudinha\Pricing\Data\Freight;

use Barrigudinha\Product\Entities\Product;
use Money\Money;

class NoFreight extends BaseFreight
{
    public function __construct(Product $product, Money $price)
    {
        parent::__construct($product, $price);

        $this->freight = Money::BRL(0);
    }

    public function get(): Money
    {
        return $this->freight;
    }
}
