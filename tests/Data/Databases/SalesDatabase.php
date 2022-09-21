<?php

namespace Tests\Data\Databases;

use Src\Users\Domain\Models\User;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Sales\SaleItemData;
use Tests\Data\Models\Sales\SaleOrderData;

class SalesDatabase
{
    public static function setup(User $user)
    {
        $productBabyCarriage = ProductData::babyCarriage($user);
        $productBabyChair = ProductData::babyChair($user);
        $productBabyPacifier = ProductData::babyPacifier($user);
        $shopee = MarketplaceData::shopee($user);
        $olist = MarketplaceData::olist($user);

        SaleOrderData::persisted(
            $user,
            [
                'sale_order_id' => '100',
                'purchase_order_id' => '10',
                'store_id' => '1234567',
                'total_profit' => 250.0,
                'total_value' => 1450.0,
            ],
            [
                SaleItemData::make($productBabyCarriage),
                SaleItemData::make($productBabyChair),
            ],
            $shopee,
        );

        SaleOrderData::persisted(
            $user,
            [
                'sale_order_id' => '101',
                'purchase_order_id' => '11',
                'store_id' => '1234567',
                'total_profit' => 20.0,
                'total_value' => 100.0,
            ],
            [
                SaleItemData::make($productBabyPacifier),
                SaleItemData::make($productBabyPacifier),
                SaleItemData::make($productBabyPacifier),
                SaleItemData::make($productBabyPacifier),
                SaleItemData::make($productBabyPacifier),
            ],
            $shopee
        );

        SaleOrderData::persisted(
            $user,
            [
                'sale_order_id' => '101',
                'purchase_order_id' => '11',
                'store_id' => '1234567',
                'total_profit' => 120.0,
                'total_value' => 899.0,
            ],
            [
                SaleItemData::make($productBabyCarriage),
            ],
            $olist
        );
    }
}
