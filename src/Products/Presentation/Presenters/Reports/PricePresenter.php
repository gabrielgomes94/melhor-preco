<?php

namespace Src\Products\Presentation\Presenters\Reports;

use Src\Math\Money;
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

            return [
                'value' => (string) Money::fromFloat($value),
                'profit' => (string) Money::fromFloat($profit),
                'marketplaceName' => $marketplaceName,
                'margin' => (string) Percentage::fromFraction($price->getMargin()),
            ];
        })->all();
    }
}
