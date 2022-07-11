<?php

namespace Src\Sales\Infrastructure\Laravel\Models\Casts;

use Exception;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Src\Sales\Domain\Models\ValueObjects\SaleValue;

class SaleValueCast implements CastsAttributes
{
    /**
     * @inheritDoc
     */
    public function get($model, string $key, $value, array $attributes)
    {
        return new SaleValue(
            discount: $model->discount,
            freight: $model->freight,
            totalProducts: $model->total_products,
            totalValue: $model->total_value
        );
    }

    /**
     * @inheritDoc
     */
    public function set($model, string $key, $value, array $attributes)
    {
        if (!$value instanceof SaleValue) {
            throw new Exception('Invalid type of value');
        }

        return [
            'discount' => $value->discount(),
            'freight' => $value->freight(),
            'total_products' => $value->totalProducts(),
            'total_value' => $value->totalValue(),
        ];
    }
}
