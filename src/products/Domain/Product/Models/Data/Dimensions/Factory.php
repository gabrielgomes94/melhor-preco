<?php

namespace Src\Products\Domain\Product\Models\Data\Dimensions;

use Src\Products\Domain\Product\Models\Product;

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
