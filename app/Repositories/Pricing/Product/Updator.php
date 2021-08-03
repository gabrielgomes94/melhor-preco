<?php

namespace App\Repositories\Pricing\Product;

use App\Models\Price as PriceModel;
use App\Models\Product as ProductModel;
use Barrigudinha\Product\Product;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;

/**
 * @deprecated
 */
class Updator
{
    private DecimalMoneyFormatter $moneyFormatter;

    public function __construct()
    {
        $this->moneyFormatter = new DecimalMoneyFormatter(new ISOCurrencies());
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
        $model->weight = $product->dimensions()->weight();
        $model->parent_sku = $product->parentSku();
        $model->has_variations = $product->hasVariations();

        foreach ($product->posts() as $post) {
            if ($price = $model->getPrice($post->store()->slug())) {
                $price->commission = $post->store()->commission();
                $price->profit = $this->formatMoney($post->profit());
                $price->store = $post->store()->code();
                $price->store_sku_id = $post->store()->storeSkuId();
                $price->value = $this->formatMoney($post->price());

                $price->save();

                continue;
            }

            $price = new PriceModel([
                'commission' => $post->store()->commission(),
                'profit' => $this->formatMoney($post->profit()),
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
