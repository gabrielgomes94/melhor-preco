<?php

namespace App\Repositories\Pricing\Product;

use App\Models\Price as PriceModel;
use Barrigudinha\Pricing\Data\Product;
use App\Models\Product as ProductModel;
use Barrigudinha\Pricing\Services\PriceCalculator\Calculate;

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

        foreach ($product->stores() ?? [] as $store) {
            $commission = config('stores.b2w.commission');
            $calculatedPrice = $this->service->calculate($product, [
                'commission' => $commission,
                'desiredPrice' => $store->price(),
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
