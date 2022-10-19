<?php

namespace Tests\Data\Models\Sales;

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Sales\Infrastructure\Laravel\Models\SaleOrder;
use Src\Users\Infrastructure\Laravel\Models\User;
use Tests\Data\Models\Products\ProductData;

class SaleOrderData
{
    public static function sale_100(
        User $user,
        array $data = [],
        ?Marketplace $marketplace = null
    ): SaleOrder
    {
        $data = array_merge(
            $data,
            [
                'sale_order_id' => '100',
                'store_sale_order_id' => '01',
                'total_profit' => 6,
                'total_products' => 2,
                'total_value' => 2 * 19.9,
            ],
        );

        $saleItems = [
            SaleItemData::make(
                ProductData::babyPacifier($user),
                [
                    'quantity' => 2,
                    'unitValue' => 19.90,
                ]
            )
        ];

        return SaleOrderData::persisted($user, $data, $saleItems, $marketplace);
    }

    public static function sale_101(
        User $user,
        array $data = [],
        ?Marketplace $marketplace = null
    ): SaleOrder
    {
        $data = array_merge(
            $data,
            [
                'sale_order_id' => '101',
                'store_sale_order_id' => '12',
                'total_profit' => 120.0,
                'total_products' => 1,
                'total_value' => 899.9
            ],
        );

        $saleItems = [
            SaleItemData::make(
                ProductData::babyCarriage($user),
                [
                    'quantity' => 1,
                    'unitValue' => 899.90,
                ]
            )
        ];

        return SaleOrderData::persisted($user, $data, $saleItems, $marketplace);
    }

    public static function sale_102(
        User $user,
        array $data = [],
        ?Marketplace $marketplace = null
    ): SaleOrder
    {
        $data = array_merge(
            $data,
            [
                'sale_order_id' => '102',
                'store_sale_order_id' => '13',
                'total_profit' => 200.0,
                'total_products' => 2,
                'total_value' => 899.9 + 599.9 + 100,
                'freight' => 100,
            ],
        );

        $saleItems = [
            SaleItemData::make(
                ProductData::babyCarriage($user),
                [
                    'quantity' => 1,
                    'unitValue' => 899.90,
                ]
            ),
            SaleItemData::make(
                ProductData::babyChair($user),
                [
                    'quantity' => 1,
                    'unitValue' => 599.90,
                ]
            ),
        ];

        return SaleOrderData::persisted($user, $data, $saleItems, $marketplace);
    }

    public static function sale_103(
        User $user,
        array $data = [],
        ?Marketplace $marketplace = null
    ): SaleOrder
    {
        $data = array_merge(
            $data,
            [
                'sale_order_id' => '103',
                'store_sale_order_id' => '14',
                'total_profit' => 85.0,
                'total_products' => 1,
                'total_value' => 549.9 + 62.25,
                'freight' => 62.25,
            ],
        );

        $saleItems = [
            SaleItemData::make(
                ProductData::cradle($user),
                [
                    'quantity' => 1,
                    'unitValue' => 549.90,
                ]
            )
        ];

        return SaleOrderData::persisted($user, $data, $saleItems, $marketplace);
    }

    public static function sale_104(
        User $user,
        array $data = [],
        ?Marketplace $marketplace = null
    ): SaleOrder
    {
        $data = array_merge(
            $data,
            [
                'sale_order_id' => '104',
                'store_sale_order_id' => '15',
                'total_profit' => 145.0,
                'total_products' => 1,
                'total_value' => 1299.90 + 100,
                'freight' => 100,
            ],
        );

        $saleItems = [
            SaleItemData::make(
                ProductData::kitCradleAndCarriage($user),
                [
                    'quantity' => 1,
                    'unitValue' => 1299.90,
                ]
            )
        ];

        return SaleOrderData::persisted($user, $data, $saleItems, $marketplace);
    }

    public static function persisted(
        User $user,
        array $data = [],
        array $saleItems = [],
        ?Marketplace $marketplace = null
    ): SaleOrder
    {
        $data = array_merge(
            [
                'sale_order_id' => '100',
                'integration' => 'bling',
                'store_id' => $marketplace?->getErpId() ?? '1234567',
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

        if (empty($data['uuid'])) {
            $saleOrder->uuid = Uuid::uuid4();
        } else {
            $saleOrder->uuid = $data['uuid'];
        }

        if ($marketplace) {
            $saleOrder->marketplace()->associate($marketplace);
            $saleOrder->store_id = $marketplace->getErpId();
        }

        $saleOrder->save();

        $saleOrder->shipment()->save(
            ShipmentData::build($saleOrder)
        );
        $saleOrder->invoice()->save(
            SaleInvoiceData::build($saleOrder)
        );

        foreach ($saleItems as $saleItem) {
            $saleItem->sale_order_id = $saleOrder->getIdentifiers()->saleOrderId();
            $saleOrder->items()->save($saleItem);
        }

        $saleOrder->items()->saveMany($saleItems);

        return $saleOrder;
    }
}
