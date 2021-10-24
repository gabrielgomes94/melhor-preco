<?php

namespace Src\Products\Application\Factories;

use Src\Products\Domain\Product\Models\Data\Costs\Costs as CostsObject;
use Src\Products\Domain\Product\Models\Data\ProductData;

class Costs
{
    public static function make(array $data, ProductData $product): CostsObject
    {
        return new CostsObject(
            purchasePrice: $data['purchasePrice'] ?? $product->getCosts()->purchasePrice(),
            additionalCosts: $data['additionalCosts'] ?? $product->getCosts()->additionalCosts(),
            taxICMS: $data['taxICMS'] ?? $product->getCosts()->taxICMS(),
        );
    }
}
