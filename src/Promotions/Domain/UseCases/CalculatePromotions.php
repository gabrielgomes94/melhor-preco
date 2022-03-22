<?php

namespace Src\Promotions\Domain\UseCases;

use Money\Money;
use Ramsey\Uuid\Uuid;
use Src\Calculator\Domain\Services\Contracts\CalculatePost;
use Src\Calculator\Domain\Services\Contracts\CalculatorOptions;
use Src\Marketplaces\Application\Exceptions\MarketplaceNotFoundException;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Prices\Domain\Models\Price;
use Src\Promotions\Domain\Data\PromotionSetup;
use Src\Promotions\Infrastructure\Laravel\Models\Promotion;

class CalculatePromotions
{
    private CalculatePost $calculatePost;
    private MarketplaceRepository $marketplaceRepository;

    public function __construct(CalculatePost $calculatePost, MarketplaceRepository $marketplaceRepository)
    {
        $this->calculatePost = $calculatePost;
        $this->marketplaceRepository = $marketplaceRepository;
    }

    public function calculate(PromotionSetup $data)
    {
        $marketplace = $this->marketplaceRepository->getBySlug($data->marketplaceSlug);

        if (!$marketplace) {
            throw new MarketplaceNotFoundException();
        }

        $products = $this->getProducts($marketplace, $data);

        // @todo: delegar para um repositório
        $promotion = new Promotion();
        $promotion->uuid = Uuid::uuid4();
        $promotion->fill([
            'name' => $data->name,
            'products' => $products,
            'discount' => $data->getDiscount(),
            'begin_date' => $data->promotionBeginDate,
            'end_date' => $data->promotionEndDate,
            'max_products_limit' => $data->maxProductsQuantity,
        ]);

        $promotion->save();

        return $promotion;
    }

    private function getProducts(?\Src\Marketplaces\Application\Models\Marketplace $marketplace, PromotionSetup $data)
    {
        $prices = $marketplace->prices;

        $prices = $prices->filter(function (Price $price) use ($data) {
            $calculatedPrice = $this->calculatePost->calculatePost($price, [
                CalculatorOptions::DISCOUNT_RATE => $data->maximumDiscount,
            ]);

            return $calculatedPrice->getMargin() >= $data->minimumMargin->get() &&
                $calculatedPrice->getProfit()->greaterThan(Money::BRL(0));
        });

        $prices = $prices->transform(function (Price $price) {
            return [
                'priceId' => $price->getId(),
                'sku' => $price->getProductSku(),
                'value' => $price->getValue(),
                'profit' => $price->getProfit(),
                'margin' => $price->getMargin()->get(),
                'name' => $price->getProduct()->getDetails()->getName(),
                'store_sku_id' => $price->getStoreSkuId(),
            ];
        })->all();

        foreach ($prices as $price) {
            $products[] = $price;
        }

        return $products ?? [];
    }
}
