<?php

namespace Src\Promotions\Infrastructure\Laravel\Services;

use Illuminate\Support\Collection;
use Src\Calculator\Domain\Services\Contracts\CalculatePost;
use Src\Calculator\Domain\Services\Contracts\CalculatorOptions;
use Src\Marketplaces\Domain\Models\Contracts\Marketplace;
use Src\Math\MathPresenter;
use Src\Math\MoneyTransformer;
use Src\Prices\Domain\Models\Price;
use Src\Promotions\Domain\Data\PromotionSetup;

class FilterProfitableProducts implements \Src\Promotions\Domain\Services\FilterProfitableProducts
{
    public function __construct(
        private CalculatePost $calculatePost
    )
    {}

    public function get(Marketplace $marketplace, PromotionSetup $promotionData): array
    {
        $prices = $this->filterProfitablePrices($marketplace, $promotionData);
        $prices = $this->mapCalculatePrices($promotionData, $prices);
        $prices = $this->transformPrices($prices);

        foreach ($prices->toArray() as $price) {
            $products[] = $price;
        }

        return $products ?? [];
    }

    private function filterProfitablePrices(
        Marketplace $marketplace,
        PromotionSetup $promotionData
    ): Collection
    {
        $prices = $marketplace->getPrices();

        return $prices->filter(function (Price $price) use ($promotionData) {
            $parameters = [
                CalculatorOptions::DISCOUNT_RATE => $promotionData->discount,
            ];

            $calculatedPrice = $this->calculatePost->calculatePost($price, $parameters);

            return $calculatedPrice->isProfitable() && $calculatedPrice->getMargin() >= 5;
        });
    }

    private function mapCalculatePrices(
        PromotionSetup $promotionData,
        Collection $prices
    ): Collection
    {
        return $prices->map(function (Price $price) use ($promotionData) {
            $parameters = [
                CalculatorOptions::DISCOUNT_RATE => $promotionData->discount,
            ];

            $calculatedPrice = $this->calculatePost->calculatePost($price, $parameters);

            $price->value = MoneyTransformer::toFloat($calculatedPrice->get());
            $price->profit = MoneyTransformer::toFloat($calculatedPrice->getProfit());

            return $price;
        });
    }

    private function transformPrices(Collection $prices): Collection
    {
        return $prices->transform(function (Price $price) {
            return [
                'priceId' => $price->getId(),
                'sku' => $price->getProductSku(),
                'value' => $price->getValue(),
                'profit' => $price->getProfit(),
                'margin' => $price->getMargin()->get(),
                'name' => $price->getProduct()->getDetails()->getName(),
                'store_sku_id' => $price->getStoreSkuId(),
            ];
        });
    }
}
