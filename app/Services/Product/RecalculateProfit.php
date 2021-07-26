<?php

namespace App\Services\Product;

use App\Repositories\Pricing\Product\Updator;
use App\Repositories\Product\FinderDB;
use Barrigudinha\Pricing\Price\Services\CalculateProduct;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;

class RecalculateProfit
{
    private FinderDB $repository;
    private CalculateProduct $calculateProductService;
    private Updator $productUpdator;
    private UpdatePrice $updatePrice;

    public function __construct(FinderDB $repository, CalculateProduct $calculateProductService, Updator $productUpdator, UpdatePrice $updatePrice)
    {
        $this->repository = $repository;
        $this->calculateProductService = $calculateProductService;
        $this->productUpdator = $productUpdator;
        $this->updatePrice = $updatePrice;
    }

    public function recalculateAll(): void
    {
        $products = $this->repository->all();

        foreach ($products as $product) {
            foreach ($product->posts() as $post) {
                $value = $this->formatMoney($post->price());

                $this->updatePrice->execute($product, $post->store(), $value);
            }
        }
    }

    private function formatMoney(Money $money): float
    {
        $moneyFormatter = new DecimalMoneyFormatter(new ISOCurrencies());
        $value = $moneyFormatter->format($money);

        return (float) $value;
    }
}
