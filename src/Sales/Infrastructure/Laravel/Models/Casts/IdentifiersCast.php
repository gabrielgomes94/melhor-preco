<?php

namespace Src\Sales\Infrastructure\Laravel\Models\Casts;

use Exception;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Src\Sales\Domain\Models\ValueObjects\SaleIdentifiers;

class IdentifiersCast implements CastsAttributes
{
    /**
     * @inheritDoc
     */
    public function get($model, string $key, $value, array $attributes)
    {
        return new SaleIdentifiers(
            saleOrderId: $model->sale_order_id,
            uuid: $model->uuid,
            integration: $model->integration,
            storeId: $model->store_id,
            storeSaleOrderId: $model->store_sale_order_id
        );
    }

    /**
     * @inheritDoc
     */
    public function set($model, string $key, $value, array $attributes)
    {
        if (!$value instanceof SaleIdentifiers) {
            throw new Exception('Invalid type of value');
        }

        return [
            'sale_order_id' => $value->saleOrderId(),
            'integration' => $value->integration(),
            'store_id' => $value->storeId(),
            'store_sale_order_id' => $value->storeSaleOrderId(),
        ];
    }
}
