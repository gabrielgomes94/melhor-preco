<?php

namespace Tests\Data\Models\Products;

use Src\Products\Domain\Models\Product\Product;

class ProductData
{
    public static function make(array $data = []): Product
    {
        $data = self::getData($data);

        return new Product($data);
    }

    public static function makePersisted(array $data = []): Product
    {
        $data = self::getData($data);
        $product = new Product($data);
        $product->save();

        return $product->refresh();
    }

    private static function getData(array $data = []): array
    {
        return array_replace(
            [
                'erp_id' => '15865921214',
                'sku' => '3670',
                'ean' => '7908200101745',
                'name' => 'Canguru Balbi Vermelho',
                'brand' => 'Galzerano',
                'purchase_price' => 99.0,
                'tax_icms' => 12,
                'images' => [],
                'additional_costs' => 0.0,
                'depth' => 11,
                'height' => 25,
                'width' => 28,
                'weight' => 0.3,
                'parent_sku' => null,
                'has_variations' => false,
                'composition_products' => [],
                'is_active' => true,
                'category_id' => null,
                'quantity' => 10,
            ],
            $data
        );
    }
}
