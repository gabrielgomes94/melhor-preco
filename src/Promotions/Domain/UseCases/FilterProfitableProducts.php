<?php

namespace Src\Promotions\Domain\UseCases;

use Illuminate\Support\Collection;
use Src\Calculator\Domain\Services\Contracts\CalculatePost;
use Src\Calculator\Domain\Services\Contracts\CalculatorOptions;
use Src\Marketplaces\Domain\Models\Contracts\Marketplace;
use Src\Math\MoneyTransformer;
use Src\Prices\Domain\Models\Price;
use Src\Promotions\Domain\Data\TransferObjects\PromotionSetup;
use Src\Calculator\Domain\Models\Price\Contracts\Price as PriceCalculated;

class FilterProfitableProducts implements \Src\Promotions\Domain\UseCases\Contracts\FilterProfitableProducts
{
    public function __construct(
        private CalculatePost $calculatePost
    )
    {}

    public function get(Marketplace $marketplace, PromotionSetup $promotionData): array
    {
        $prices = $this->filterProfitablePrices($marketplace, $promotionData);

        return $prices->all();
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

            return $this->isInProfitRange($calculatedPrice, $promotionData);
        });
    }

    private function isInProfitRange(
        PriceCalculated $calculatedPrice,
        PromotionSetup $promotionData
    ): bool
    {
        return $calculatedPrice->isProfitable() &&
            $calculatedPrice->getMargin() >= $promotionData->minimumMargin->get();
    }

    // @deprecated
//    private function mapCalculatePrices(
//        PromotionSetup $promotionData,
//        Collection $prices
//    ): Collection
//    {
//        return $prices->map(function (Price $price) use ($promotionData) {
//            $parameters = [
//                CalculatorOptions::DISCOUNT_RATE => $promotionData->discount,
//            ];
//
//            $calculatedPrice = $this->calculatePost->calculatePost($price, $parameters);
//
//            $price->value = MoneyTransformer::toFloat($calculatedPrice->get());
//            $price->profit = MoneyTransformer::toFloat($calculatedPrice->getProfit());
//
//            return $price;
//        });
//    }
//
//    // @todo: mover para camada de apresentação
//    private function transformPrices(Collection $prices): Collection
//    {
//        return $prices->transform(function (Price $price) {
//            return [
//                'priceId' => $price->getId(),
//                'sku' => $price->getProductSku(),
//                'value' => $price->getValue(),
//                'profit' => $price->getProfit(),
//                'margin' => $price->getMargin()->get(),
//                'name' => $price->getProduct()->getDetails()->getName(),
//                'store_sku_id' => $price->getStoreSkuId(),
//            ];
//        });
//    }
}
