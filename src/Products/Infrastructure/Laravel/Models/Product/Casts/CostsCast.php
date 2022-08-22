<?php

namespace Src\Products\Infrastructure\Laravel\Models\Product\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use InvalidArgumentException;
use Src\Products\Domain\Models\ValueObjects\Costs;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;

class CostsCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        if (!$model instanceof Product) {
            throw new InvalidArgumentException('Invalid type for model parameter');
        }

        return new Costs(
            purchasePrice: $model->purchase_price ?? 0.0,
            additionalCosts: $model->additional_costs ?? 0.0,
            taxICMS: $model->tax_icms ?? 0.0
        );
    }

    public function set($model, string $key, $value, array $attributes)
    {
        if (!$value instanceof Costs) {
            throw new InvalidArgumentException('Invalid type for value parameter');
        }

        return [
            'purchase_price' => $value->purchasePrice(),
            'additional_costs' => $value->additionalCosts(),
            'tax_icms' => $value->taxICMS(),
        ];
    }
}
