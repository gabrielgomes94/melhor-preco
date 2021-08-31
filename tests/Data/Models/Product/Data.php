<?php

namespace Tests\Data\Models\Product;

class Data
{
    public static function baseProduct(): array
    {
        return [
            'id' => '2863',
            'erp_id' => '13029600281',
            'sku' => '2863',
            'name' => 'Carrinho Olympus Cappuccino',
            'purchase_price' => 600.0,
            'tax_icms' => 12.0,
            'additional_costs' => 0.0,
            'depth' => 27.0,
            'height' => 47.0,
            'width' => 83.0,
            'weight' => 11.05,
            'parent_sku' => null,
            'has_variations' => false,
            'composition_products' => [],
            'is_active' => true,
            'prices' => self::basePrices(),
        ];
    }

    public static function basePrices(): array
    {
        return [
            [
                'commission' => 16.0,
                'profit' => 0,
                'store' => 'b2w',
                'store_sku_id' => '2863',
                'value' => 1199.90,
                'additional_costs' => 0.0,
            ],
            [
                'commission' => 12.8,
                'profit' => 0,
                'store' => 'magalu',
                'store_sku_id' => '13029600281',
                'value' => 1199.90,
                'additional_costs' => 0.0,
            ],
            [
                'commission' => 20.0,
                'profit' => 0,
                'store' => 'olist',
                'store_sku_id' => 'PRD7SR15JPALO79V',
                'value' => 1199.90,
                'additional_costs' => 0.0,
            ],
            [
                'commission' => 16.5,
                'profit' => 0,
                'store' => 'mercado_livre',
                'store_sku_id' => 'MLB1927539444',
                'value' => 1199.90,
                'additional_costs' => 0.0,
            ],
            [
                'commission' => 12.0,
                'profit' => 0,
                'store' => 'shopee',
                'store_sku_id' => '102096325244123',
                'value' => 1199.90,
                'additional_costs' => 0.0,
            ],
        ];
    }
}
