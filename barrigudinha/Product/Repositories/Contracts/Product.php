<?php

namespace Barrigudinha\Product\Repositories\Contracts;

use Barrigudinha\Product\Product as ProductData;

interface Product
{
    public function get(string $sku): ?ProductData;
}
