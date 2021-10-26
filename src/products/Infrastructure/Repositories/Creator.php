<?php

namespace Src\Products\Infrastructure\Repositories;

use Src\Prices\Price\Domain\Models\Price as PriceModel;
use Src\Products\Domain\Product\Models\Product as ProductModel;
use Src\Products\Domain\Store\Factory;

//use App\Repositories\Store\Store;

class Creator
{
    public function createFromArray(array $data)
    {
        $model = new ProductModel([
            'id' => $data['id'],
            'erp_id' => $data['erp_id'],
            'sku' => $data['sku'],
            'name' => $data['name'],
            'brand' => $data['brand'],
            'purchase_price' => $data['purchase_price'],
            'depth' => $data['depth'],
            'height' => $data['height'],
            'width' => $data['width'],
            'weight' => $data['weight'],
            'tax_icms' => 0.0,
            'parent_sku' => $data['parent_sku'] ?? null,
            'has_variations' => $data['has_variations'] ?? false,
            'composition_products' => $data['composition_products'] ?? [],
            'is_active' => $data['is_active']
        ]);

        $model->save();

        foreach ($data['stores'] as $store) {
            $price = new PriceModel([
                'store' => $store['slug'],
                'store_sku_id' => $store['storeSkuId'],
                'value' => $store['price'],
                'commission' => $this->getCommission($store['slug']),
                'profit' => 0.0,
            ]);

            $model->prices()->save($price);
        }

        return $model;
    }

    private function getCommission(string $storeSlug): float
    {
        $store = Factory::make($storeSlug);

        return $store->getDefaultCommission();
    }
}
