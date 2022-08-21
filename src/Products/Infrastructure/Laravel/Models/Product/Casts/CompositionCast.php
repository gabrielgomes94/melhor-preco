<?php

namespace Src\Products\Infrastructure\Laravel\Models\Product\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use InvalidArgumentException;
use Src\Products\Domain\Models\ValueObjects\Composition;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;

class CompositionCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        if (!$model instanceof Product) {
            throw new InvalidArgumentException('Invalid type for model parameter');
        }

        foreach ($model->composition_products as $product) {
            $compositionProduct = $this
                ->where('sku', $product)
                ->fromUser($product->getUserId())
                ->first();

            if (!$compositionProduct) {
                continue;
            }

            $compositionProducts[] = $compositionProduct;
        }

        return new Composition($compositionProducts ?? []);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        if (!$value instanceof Composition) {
            throw new InvalidArgumentException('Invalid type for value parameter');
        }

        return $this->composition_products = $value->getSkus();
    }
}
