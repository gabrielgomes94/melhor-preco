<?php

namespace Barrigudinha\Product\Data\Variations;

use Barrigudinha\Product\Product;

class Variations
{
    /**
     * @var Product[]
     */
    protected array $products;

    /**
     * @param Product[] $products
     */
    public function __construct(array $products = [])
    {
        $this->products = $products;
    }

    /**
     * @return Product[]
     */
    public function get(): array
    {
        return $this->products;
    }
}
