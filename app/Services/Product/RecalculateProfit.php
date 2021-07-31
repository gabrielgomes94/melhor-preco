<?php

namespace App\Services\Product;

use App\Repositories\Pricing\Product\Updator;
use App\Repositories\Product\FinderDB;
use App\Services\Product\Update\UpdatePosts;
use Barrigudinha\Pricing\Price\Services\CalculateProduct;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;

class RecalculateProfit
{
    private FinderDB $repository;
    private UpdatePosts $updatePosts;

    public function __construct(FinderDB $repository, UpdatePosts $updatePosts)
    {
        $this->repository = $repository;
        $this->updatePosts = $updatePosts;
    }

    public function recalculateAll(): void
    {
        $products = $this->repository->all();

        foreach ($products as $product) {
            foreach ($product->posts() as $post) {
                $value = $this->formatMoney($post->price());

                $this->updatePosts->execute($product, $post->store(), $value);
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
