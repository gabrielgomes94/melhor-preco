<?php

namespace Barrigudinha\Product\Data\Variations;

use Barrigudinha\Product\Entities\Product;
use Barrigudinha\Product\Data\Variations\Variations;

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
