<?php

namespace Src\Products\Application\Factories;

use Src\Products\Domain\Data\Dimensions as DimensionsObject;
use Src\Products\Domain\Entities\Product;

class Dimensions
{
    public static function make(array $data, Product $product): DimensionsObject
    {
        return new DimensionsObject(
            depth: $data['depth'] ?? $product->dimensions()->depth(),
            height: $data['height'] ?? $product->dimensions()->height(),
            width: $data['width'] ?? $product->dimensions()->width(),
            weight: $data['weight'] ?? $product->dimensions()->weight()
        );
    }
}
