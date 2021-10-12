<?php

namespace Src\Products\Application\Factories;

use Src\Products\Domain\Data\Costs as CostsObject;
use Src\Products\Domain\Entities\Product;

class Costs
{
    public static function make(array $data, Product $product): CostsObject
    {
        return new CostsObject(
            purchasePrice: $data['purchasePrice'] ?? $product->costs()->purchasePrice(),
            additionalCosts: $data['additionalCosts'] ?? $product->costs()->additionalCosts(),
            taxICMS: $data['taxICMS'] ?? $product->costs()->taxICMS(),
        );
    }
}
