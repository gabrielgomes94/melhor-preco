<?php

namespace Tests\Data\Models\Prices;

use Ramsey\Uuid\Uuid;
use Src\Prices\Infrastructure\Laravel\Models\Price;
use Src\Products\Domain\Models\Product;
use Src\Users\Infrastructure\Laravel\Models\User;

class PriceData
{
    public static function persisted(User $user, array $data = [], ?Product $product = null)
    {
        $price = new Price(
            array_merge([
                'commission' => 10.0,
                'profit' => 2.0,
                'margin' => (2.0 / 10.0) * 100,
                'store' => 'magalu',
                'value' => 10.0,
                'additional_costs' => 0.0,
                'product_sku' => '1234',
                'store_sku_id' => '3213123',
                'marketplace_erp_id' => '123456',
            ], $data)
        );
        $price->user_id = $user->id;

        if ($product) {
            $price->product_uuid = $product->getUuid();
            $price->uuid = Uuid::uuid4();
            $price->save();

            return $price;
        }

        $price->product_uuid = $data['product_uuid'];
        $price->uuid = $data['uuid'] ?? Uuid::uuid4();
        $price->save();

        return $price;
    }
}
