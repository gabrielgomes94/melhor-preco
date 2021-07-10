<?php

namespace App\Repositories\Pricing\Product;

use App\Models\Price as PriceModel;
use App\Models\Product as ProductModel;
use Barrigudinha\Pricing\Services\PriceCalculator\Calculate;
use Barrigudinha\Product\Product;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;

class Updator
{
    private Calculate $service;
    private DecimalMoneyFormatter $moneyFormatter;

    public function __construct(Calculate $service)
    {
        $this->service = $service;
        $this->moneyFormatter = new DecimalMoneyFormatter(new ISOCurrencies());
    }

    public function update(string $productId, array $data)
    {
        if (!$model = ProductModel::find($productId)) {
            return false;
        }

        $model->purchase_price = $data['purchasePrice'];
        $model->tax_icms = $data['taxICMS'];
        $model->additional_costs = $data['additionalCosts'];

        if (isset($data['depth'])) {
            $model->depth = $data['depth'];
        }
        if (isset($data['height'])) {
            $model->height = $data['height'];
        }
        if (isset($data['width'])) {
            $model->width = $data['width'];
        }

        return $model->save();
    }

    public function updateICMS(string $sku, float $taxICMS): bool
    {
        if ($model = ProductModel::find($sku)) {
            $model->tax_icms = $taxICMS;

            return $model->save();
        }

        return false;
    }

    public function sync(Product $product, ProductModel $model): bool
    {
        $model->erp_id = $product->erpId();
        $model->purchase_price = $product->costs()->purchasePrice();
        $model->additional_costs = $product->costs()->additionalCosts();
        $model->tax_icms = $product->costs()->taxICMS();
        $model->depth = $product->dimensions()->depth();
        $model->height = $product->dimensions()->height();
        $model->width = $product->dimensions()->width();
        $model->weight = $product->weight();
        $model->parent_sku = $product->parentSku();
        $model->has_variations = $product->hasVariations();

        foreach ($product->posts() as $post) {
            $calculatedPrice = $this->service->calculate(
                product: $product,
                store: $post->store()->code(),
                desiredPrice: $post->price(),
                commission: $post->store()->commission(),
            );

            if ($price = $model->getPrice($post->store()->slug())) {
                $price->commission = $post->store()->commission();
                $price->profit = $this->formatMoney($calculatedPrice->price()->profit());
                $price->store = $post->store()->code();
                $price->store_sku_id = $post->store()->storeSkuId();
                $price->value = $this->formatMoney($post->price());

                $price->save();

                continue;
            }

            $price = new PriceModel([
                'commission' => $post->store()->commission(),
                'profit' => $this->formatMoney($calculatedPrice->price()->profit()),
                'store' => $post->store()->code(),
                'store_sku_id' => $post->store()->storeSkuId(),
                'value' => $this->formatMoney($post->price()),
            ]);

            $model->prices()->save($price);
        }

        return $model->save();
    }

    private function formatMoney(Money $price): string
    {
        return $this->moneyFormatter->format($price);
    }
}
