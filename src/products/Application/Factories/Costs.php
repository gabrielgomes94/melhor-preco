<?php

namespace Src\Products\Application\Factories;

use Src\Products\Domain\Models\Product\Data\Costs\Costs as CostsObject;
use Src\Products\Domain\Models\Product\Product;

class Costs
{
    public static function make(array $data, Product $product): CostsObject
    {
        $costs = $product->getCosts();

        return new CostsObject(
            purchasePrice: $data['purchasePrice'] ?? $costs->purchasePrice(),
            additionalCosts: $data['additionalCosts'] ?? $costs->additionalCosts(),
            taxICMS: $data['taxICMS'] ?? $costs->taxICMS(),
        );
    }
}
