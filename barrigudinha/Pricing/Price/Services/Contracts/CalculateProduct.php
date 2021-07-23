<?php

namespace Barrigudinha\Pricing\Price\Services\Contracts;

use Barrigudinha\Product\Product;

interface CalculateProduct
{
    public function recalculate(Product $product): Product;
}
