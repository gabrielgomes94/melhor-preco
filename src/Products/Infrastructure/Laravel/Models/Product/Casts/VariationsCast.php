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

        if ($model->parent_sku) {
            $variations = $this->getVariations($model, $model->parent_sku);

            return new Variations($model->parent_sku, $variations);
        }

        $variations = $this->getVariations($model, $model->sku);

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

    private function getVariations(Product $model, string $sku): array
    {
        return $model->withParentSku($model->parent_sku)
            ->fromUser($model->user_id)
            ->get()
            ->all();
    }
}
