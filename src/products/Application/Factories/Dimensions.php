<?php

namespace Src\Products\Application\Factories;

use Src\Products\Domain\Product\Models\Product;
use Src\Products\Domain\Product\Models\Data\Dimensions\Dimensions as DimensionsObject;

class Dimensions
{
    public static function make(array $data, Product $product): DimensionsObject
    {
        $product = $product->data();

        return new DimensionsObject(
            depth: $data['depth'] ?? $product->getDimensions()->depth(),
            height: $data['height'] ?? $product->getDimensions()->height(),
            width: $data['width'] ?? $product->getDimensions()->width(),
            weight: $data['weight'] ?? $product->getDimensions()->weight()
        );
    }
}
