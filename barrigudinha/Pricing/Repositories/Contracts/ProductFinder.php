<?php

namespace Barrigudinha\Pricing\Repositories\Contracts;

use Barrigudinha\Product\Product;

interface ProductFinder
{
    /**
     * @return Product[]
     */
    public function all(): array;

    public function get(string $sku): ?Product;
}
