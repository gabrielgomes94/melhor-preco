<?php

namespace Src\Products\Domain\Product\Models\Data\Costs;

use Src\Products\Domain\Product\Models\Product;

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
