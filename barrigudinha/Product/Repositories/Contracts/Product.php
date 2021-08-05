<?php

namespace Barrigudinha\Product\Repositories\Contracts;

use Barrigudinha\Product\Entities\Product as ProductData;

interface Product
{
    public function get(string $sku): ?ProductData;
}
