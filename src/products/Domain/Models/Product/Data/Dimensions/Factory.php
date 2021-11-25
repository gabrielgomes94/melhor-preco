<?php

namespace Src\Products\Domain\Models\Product\Data\Dimensions;

use Src\Products\Domain\Models\Product\Product;

class Factory
{
    public static function make(Product $product): Dimensions
    {
        return new Dimensions(
            depth: $product->depth,
            height: $product->height,
            width: $product->width,
            weight: $product->weight
        );
    }
}
