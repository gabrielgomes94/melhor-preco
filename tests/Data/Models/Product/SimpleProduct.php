<?php

namespace Tests\Data\Models\Product;

use App\Models\Price;
use App\Models\Product;

class SimpleProduct
{
    public static function make(?array $overwrite = []): array
    {
        if (empty($overwrite)) {
            return [self::getProduct(self::getData())];
        }

        foreach ($overwrite as $attributes) {
            $products[] = self::getProduct(self::getData($attributes));
        }

        return $products ?? [];
    }

    public static function create(?array $overwrite = []): array
    {
        $products = self::make($overwrite);

        foreach ($products as $product) {
            $product->save();

            foreach ($product->prices as $price) {
                $product->prices()->save($price);
            }
        }

        return $products;
    }

    private static function getProduct(array $data): Product
    {
        $product = new Product($data);

        foreach ($data['prices'] as $price) {
            $product->prices->add(new Price($price));
        }

        return $product;
    }

    private static function getData(?array $overwrite = []): array
    {
        // To Do: refactor product model in order to remove sku attribute
        if (isset($overwrite['id'])) {
            $overwrite['sku'] = $overwrite['id'];
        }

        return array_merge([
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
            'prices' => self::getPriceData(),
        ], $overwrite);
    }

    private static function getPriceData(?array $overwrite = []): array
    {
        return array_merge([
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
        ], $overwrite);
    }
}
