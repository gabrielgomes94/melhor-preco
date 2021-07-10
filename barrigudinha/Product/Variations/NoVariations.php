<?php

namespace Barrigudinha\Product\Variations;

use Barrigudinha\Product\Product;

class NoVariations extends Variations
{
    /**
     * @param Product[] $products
     */
    public function __construct(array $products = [])
    {
        $this->products = [];
    }
}
