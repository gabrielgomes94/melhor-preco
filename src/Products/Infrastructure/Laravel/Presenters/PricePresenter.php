<?php

namespace Src\Products\Infrastructure\Laravel\Presenters;

use Src\Math\MathPresenter;
use Src\Math\Percentage;
use Src\Prices\Domain\Models\Price;
use Src\Products\Domain\Models\Product\Contracts\Product;

class PricePresenter
{
    public function present(Product $product): array
    {
        $prices = $product->getPrices();

        return $prices->transform(function(Price $price) {
            $profit = $price->getProfit();
            $value = $price->getValue();
            $marketplaceName = $price->getMarketplace()->getName();
            $marketplaceSlug = $price->getMarketplace()->getSlug();
            $productSku = $price->getProductSku();

            return [
                'value' => MathPresenter::money($value),
                'profit' => MathPresenter::money($profit),
                'marketplaceName' => $marketplaceName,
                'marketplaceSlug' => $marketplaceSlug,
                'margin' => MathPresenter::percentage($price->getMargin()),
                'productSku' => $productSku,
            ];
        })->all();
    }
}
