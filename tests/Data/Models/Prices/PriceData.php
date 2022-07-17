<?php

namespace Tests\Data\Models\Prices;

use Src\Prices\Infrastructure\Laravel\Models\Price;
use Src\Users\Infrastructure\Laravel\Models\User;

class PriceData
{
    public static function persisted(User $user, array $data = [])
    {
        $price = new Price(
            array_merge([
                'commission' => 10.0,
                'profit' => 2.0,
                'margin' => (2.0 / 10.0) * 100,
                'store' => 'magalu',
                'value' => 10.0,
                'additional_costs' => 0.0,
                'product_sku' => '1211',
                'store_sku_id' => '3213123',
                'marketplace_erp_id' => '123456',
            ], $data)
        );
        $price->user_id = $user->id;
        $price->save();

        return $price;
    }
}
