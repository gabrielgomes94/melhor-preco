<?php

namespace Barrigudinha\Pricing\Repositories\Contracts;

use Barrigudinha\Pricing\Data\Product as ProductData;

interface Product
{
    public function get(string $sku): ?ProductData;
}
