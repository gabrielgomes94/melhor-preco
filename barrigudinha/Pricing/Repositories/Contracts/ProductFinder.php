<?php

namespace Barrigudinha\Pricing\Repositories\Contracts;

use Barrigudinha\Pricing\Data\Product;

interface ProductFinder
{
    public function get(string $sku): ?Product;
}
