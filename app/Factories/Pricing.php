<?php

namespace App\Factories;

use App\Models\Pricing as PricingModel;
use App\Models\Product as ProductModel;
use Barrigudinha\Pricing\Data\Pricing as PricingData;
use Barrigudinha\Pricing\Data\Product;

class Pricing
{
    public function make(PricingModel $model): PricingData
    {
        $products = array_map(function (ProductModel $product) {
            $prices = $product->prices()->get()->toArray();

            return new Product([
                'sku' => $product->sku,
                'name' => $product->name,
                'purchase_price' => $product->purchasePrice ?? 0.0,
                'stores' => $product->stores,
                'depth' => $product->depth,
                'height' => $product->height,
                'width' => $product->width,
            ], $prices);
        }, $model->products->all());

        $pricing = new PricingData(
            name: $model->name,
            products: $products,
            stores: $model->stores,
            id: $model->id
        );

        return $pricing;
    }
}
