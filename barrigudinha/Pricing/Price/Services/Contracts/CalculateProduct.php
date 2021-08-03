<?php

namespace Barrigudinha\Pricing\Price\Services\Contracts;

use Barrigudinha\Product\Entities\Product;

interface CalculateProduct
{
    public function recalculate(Product $product): Product;
}
