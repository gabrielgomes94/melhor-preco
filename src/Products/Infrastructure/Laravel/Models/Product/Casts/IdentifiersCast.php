<?php

namespace Src\Products\Infrastructure\Laravel\Models\Product\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use InvalidArgumentException;
use Src\Products\Domain\Models\Product\ValueObjects\Identifiers;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;

class IdentifiersCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        if (!$model instanceof Product) {
            throw new InvalidArgumentException('Invalid type for model parameter');
        }

        return new Identifiers($model->sku, $model->erp_id);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        if (!$value instanceof Identifiers) {
            throw new InvalidArgumentException('Invalid type for value parameter');
        }

        return [
            'sku' => $value->getSku(),
            'erp_id' => $value->getErpId(),
        ];
    }
}
