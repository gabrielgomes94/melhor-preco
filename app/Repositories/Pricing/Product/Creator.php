<?php

namespace App\Repositories\Pricing\Product;

use App\Models\Price as PriceModel;
use App\Models\Product as ProductModel;
use Barrigudinha\Pricing\Services\PriceCalculator\Calculate;
use Barrigudinha\Product\Product;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;

class Creator
{
    private Calculate $service;
    private DecimalMoneyFormatter $moneyFormatter;

    public function __construct(Calculate $service)
    {
        $this->service = $service;
        $this->moneyFormatter = new DecimalMoneyFormatter(new ISOCurrencies());
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

        foreach ($product->posts() as $post) {
            $calculatedPrice = $this->service->calculate(
                product: $product,
                store: $post->store()->code(),
                desiredPrice: $post->price(),
                commission: $post->store()->commission(),
            );

            $price = new PriceModel([
                'commission' => $post->store()->commission(),
                'profit' => $calculatedPrice->price()->profit() ?? 0.0,
                'store' => $post->store()->code(),
                'store_sku_id' => $post->store()->storeSkuId(),
                'value' => $this->formatMoney($post->price()),
            ]);

            $model->prices()->save($price);
        }

        return $model;
    }

    private function formatMoney(Money $price): string
    {
        return $this->moneyFormatter->format($price);
    }
}
