<?php

namespace App\Repositories\Pricing\Product;

use App\Models\Price as PriceModel;
use App\Models\Product as ProductModel;
use Barrigudinha\Pricing\Services\PriceCalculator\Calculate;
use Barrigudinha\Product\Product;

class Creator
{
    private Calculate $service;

    public function __construct(Calculate $service)
    {
        $this->service = $service;
    }

    public function create(Product $product): ProductModel
    {
        $model = new ProductModel([
            'id' => $product->sku(),
            'sku' => $product->sku(),
            'name' => $product->name(),
            'purchase_price' => $product->purchasePrice(),
            'tax_icms' => 0.0,
            'depth' => $product->dimensions()->depth(),
            'height' => $product->dimensions()->height(),
            'width' => $product->dimensions()->width(),
            'weight' => $product->weight(),
        ]);

        $model->save();

        foreach ($product->stores() as $store) {
            $commission = config('stores.' . $store->code() . '.commission');

            $calculatedPrice = $this->service->calculate($product, [
                'commission' => $commission,
                'desiredPrice' => $store->price(),
                'store' => $store->code(),
            ]);

            $price = new PriceModel([
                'commission' => $commission,
                'profit' => $calculatedPrice['profit'] ?? 0.0,
                'store' => $store->code(),
                'store_sku_id' => $store->storeSkuId(),
                'value' => $store->price(),
            ]);

            $model->prices()->save($price);
        }

        return $model;
    }

    public function store()
    {
    }
}
