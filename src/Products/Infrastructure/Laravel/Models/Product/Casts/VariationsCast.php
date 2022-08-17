<?php

namespace Src\Products\Infrastructure\Laravel\Models\Product\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use InvalidArgumentException;
use Src\Products\Domain\Models\Product\ValueObjects\Variations;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;

class VariationsCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        if (!$model instanceof Product) {
            throw new InvalidArgumentException('Invalid type for model parameter');
        }

        $variations = $model->withParentSku($model->sku)
            ->get()
            ->all();

        if (empty($variations)) {
            return new Variations();
        }

        return new Variations($model->sku, $variations);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        if (!$value instanceof Variations) {
            throw new InvalidArgumentException('Invalid type for value parameter');
        }

        return [
            'parent_sku' => $value->getParentSku(),
            'has_variations' => (bool) count($value->get()),
        ];
    }
}
