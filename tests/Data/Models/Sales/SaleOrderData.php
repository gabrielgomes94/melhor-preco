<?php

namespace Tests\Data\Models\Sales;

use Carbon\Carbon;
use Src\Sales\Infrastructure\Laravel\Models\SaleOrder;
use Src\Users\Infrastructure\Laravel\Models\User;

class SaleOrderData
{
    public static function persisted(User $user, array $data = [], array $saleItems = []): SaleOrder
    {
        $data = array_merge(
            [
                'sale_order_id' => '100',
                'purchase_order_id' => '10',
                'integration' => 'bling',
                'store_id' => '1234567',
                'store_sale_order_id' => '12',
                'selled_at' => Carbon::create(2021, 12, 12, 15, 40),
                'dispatched_at' => Carbon::create(2021, 12, 12, 18, 00),
                'expected_arrival_at' => Carbon::create(2021, 12, 16, 12, 00),
                'discount' => 0.00,
                'freight' => 30.0,
                'status' => 'Registrada',
                'total_products' => 1,
                'total_profit' => 20.0,
                'total_value' => 100.0,
            ],
            $data
        );

        $saleOrder = new SaleOrder($data);
        $saleOrder->user()->associate($user);

        $customer = CustomerData::persisted();
        $saleOrder->customer()->associate($customer);

        $saleOrder->save();
        $saleOrder->items()->saveMany($saleItems);

        return $saleOrder;
    }
}
