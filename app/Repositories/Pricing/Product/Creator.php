<?php

namespace App\Repositories\Pricing\Product;

use App\Models\Price as PriceModel;
use Barrigudinha\Pricing\Data\Product;
use App\Models\Product as ProductModel;

class Creator
{
    public function create(Product $product): ProductModel
    {
        $model = new ProductModel([
            'sku' => $product->sku(),
            'name' => $product->name(),
            'purchase_price' => $product->purchasePrice(),
            'tax_ipi' => 0.0,
            'tax_icms' => 0.0,
            'tax_simples_nacional' => config('taxes.simples_nacional', 0.0),
            'depth' => $product->dimensions()->depth(),
            'height' => $product->dimensions()->height(),
            'width' => $product->dimensions()->width(),
        ]);
        $model->save();

        foreach($product->stores ?? [] as $store) {
            $price = new PriceModel([
                'commission' => 12.1,
                'profit' => 0.0,
                'store' => $store->code(),
                'store_sku_id' => $store->storeSkuId(),
                'value' => $store->price(),
            ]);

            $model->prices()->save($price);
        }

        return $model;
    }
}
