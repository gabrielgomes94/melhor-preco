<?php

namespace App\Factories\Product;

use Barrigudinha\Product\Data\Costs as CostsObject;
use Barrigudinha\Product\Product;

class Costs
{
    public static function make(array $data, Product $product)
    {
        return new CostsObject(
            purchasePrice: $data['purchasePrice'] ?? $product->costs()->purchasePrice(),
            additionalCosts: $data['additionalCosts'] ?? $product->costs()->additionalCosts(),
            taxICMS: $data['taxICMS'] ?? $product->costs()->taxICMS(),
        );
    }
}
