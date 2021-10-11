<?php

namespace Src\Products\Application\Services\Price;

use Src\Products\Infrastructure\Repositories\ListDB;
use Src\Products\Application\Services\Update\UpdatePosts;
use Src\Prices\Domain\Price\Services\CalculateProduct;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;

class RecalculateProfit
{
    private ListDB $repository;
    private UpdatePosts $updatePosts;

    public function __construct(ListDB $repository, UpdatePosts $updatePosts)
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
                $this->updatePosts->updatePrice($product, $post->store(), $value);
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
