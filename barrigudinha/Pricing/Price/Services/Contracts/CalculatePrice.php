<?php

namespace Barrigudinha\Pricing\Price\Services\Contracts;

use Barrigudinha\Pricing\Data\Price;
use Barrigudinha\Product\Product;
use Barrigudinha\Product\Store;
use Money\Money;

interface CalculatePrice
{
    public function calculate(
        Product $product,
        Store $store,
        Money $desiredPrice,
        array $options = []
    ): Price;
}
