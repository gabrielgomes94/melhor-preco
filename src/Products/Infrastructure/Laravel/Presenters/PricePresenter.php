<?php

namespace Src\Products\Infrastructure\Laravel\Presenters;

use Src\Math\Transformers\NumberTransformer;
use Src\Prices\Infrastructure\Laravel\Models\Price;
use Src\Products\Domain\Models\Product;

class PricePresenter
{
    public function present(Product $product): array
    {
        $prices = $product->getPrices();

        return $prices->transform(function (Price $price) {
            $profit = $price->getProfit();
            $value = $price->getValue();
            $marketplaceName = $price->getMarketplace()->getName();
            $marketplaceSlug = $price->getMarketplace()->getSlug();
            $productSku = $price->getProductSku();

            return [
                'value' => NumberTransformer::toMoney($value),
                'profit' => NumberTransformer::toMoney($profit),
                'marketplaceName' => $marketplaceName,
                'marketplaceSlug' => $marketplaceSlug,
                'margin' => NumberTransformer::toPercentage($price->getMargin()),
                'productSku' => $productSku,
            ];
        })->sortBy('marketplaceSlug')->all();
    }
}
