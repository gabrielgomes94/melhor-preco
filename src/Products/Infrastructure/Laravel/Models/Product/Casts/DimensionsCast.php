<?php

namespace Src\Products\Infrastructure\Laravel\Models\Product\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use InvalidArgumentException;
use Src\Products\Domain\Models\Product\ValueObjects\Dimensions;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;

class DimensionsCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        if (!$model instanceof Product) {
            throw new InvalidArgumentException('Invalid type for model parameter');
        }

        return new Dimensions(
            $this->depth ?? 0.0,
            $this->height ?? 0.0,
            $this->width ?? 0.0,
            $this->weight ?? 0.0
        );
    }

    public function set($model, string $key, $value, array $attributes)
    {
        if (!$value instanceof Dimensions) {
            throw new InvalidArgumentException('Invalid type for value parameter');
        }

        return [
            'depth' => $value->depth(),
            'height' => $value->height(),
            'width' => $value->width(),
            'weight' => $value->weight(),
        ];
    }
}
