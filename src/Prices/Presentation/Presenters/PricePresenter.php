<?php

namespace Src\Prices\Presentation\Presenters;

use Src\Math\MoneyTransformer;
use Src\Math\Percentage;
use Src\Products\Domain\Models\Post\Contracts\HasSecondaryPrice;
use Src\Products\Domain\Models\Post\Post;
use Src\Products\Domain\Models\Product\Contracts\Product;

class PricePresenter
{
    public function present(Product $product, ?Post $post)
    {
        if (!$post) {
            return [];
        }

        if ($post instanceof HasSecondaryPrice) {
            return array_merge(
                $this->presentPrice($product, $post),
                $this->presentSecondaryPrice($post)
            );
        }

        return $this->presentPrice($product, $post);
    }

    private function presentPrice(Product $product, Post $post): array
    {
        $price = $post->getPrice();
        $store = $post->getStore();

        return [
            'name' => $product->getDetails()->getName(),
            'sku' => $product->getSku(),
            'id' => $post->getId(),
            'store' => $store->getName(),
            'storeSlug' => $store->getSlug(),
            'mainPrice' => [
                'value' => MoneyTransformer::toFloat($price->get()),
                'profit' => MoneyTransformer::toFloat($price->getProfit()),
                'margin' => $price->getMargin(),
                'commission' => Percentage::fromFraction(
                    $price->getCommission()->getCommissionRate()
                ),
                'commissionRate' => $price->getCommission()->getCommissionRate() * 100,
            ],
        ];
    }

    private function presentSecondaryPrice(HasSecondaryPrice $post): array
    {
        return [
            'secondaryPrice' => [
                'value' => MoneyTransformer::toFloat($post->getSecondaryPrice()->get()),
                'profit' => MoneyTransformer::toFloat($post->getSecondaryPrice()->getProfit()),
                'margin' => $post->getSecondaryPrice()->getMargin(),
            ],
        ];
    }
}
