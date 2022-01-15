<?php

namespace Src\Products\Domain\Models\Product\Data\Costs;

use Src\Products\Domain\Models\Product\Product;

class Factory
{
    public static function make(Product $product): Costs
    {
        return new Costs(
            $product->purchase_price,
            $product->additional_costs,
            $product->tax_icms
        );
    }
}
