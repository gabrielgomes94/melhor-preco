<?php

namespace App\Repositories\Pricing\Product;

use App\Models\Price as PriceModel;
use App\Models\Product as ProductModel;
use App\Repositories\Store\Store;
use Barrigudinha\Product\Entities\Product;
use Barrigudinha\Store\Repositories\StoreRepository;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;

class Creator
{
    private Store $storeRepository;

    public function __construct(Store $storeRepository)
    {
        $this->storeRepository = $storeRepository;
    }

    public function createFromArray(array $data)
    {
        $model = new ProductModel([
            'id' => $data['id'],
            'erp_id' => $data['erp_id'],
            'sku' => $data['sku'],
            'name' => $data['name'],
            'purchase_price' => $data['purchase_price'],
            'depth' => $data['depth'],
            'height' => $data['height'],
            'width' => $data['width'],
            'weight' => $data['weight'],
            'tax_icms' => 0.0,
            'parent_sku' => $data['parent_sku'] ?? null,
            'has_variations' => $data['has_variations'] ?? false,
            'composition_products' => $data['composition_products'] ?? [],
        ]);

        $model->save();

        foreach ($data['stores'] as $store) {
            $price = new PriceModel([
                'store' => $store['slug'],
                'store_sku_id' => $store['storeSkuId'],
                'value' => $store['price'],
                'commission' => $this->storeRepository->commission($store['slug']),
                'profit' => 0.0,
            ]);

            $model->prices()->save($price);
        }

        return $model;
    }
}
