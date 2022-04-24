<?php

namespace Src\Prices\Presentation\Presenters;

use Src\Math\MoneyTransformer;
use Src\Math\Percentage;
use Src\Prices\Domain\Models\Price;
use Src\Products\Domain\Models\Post\Contracts\HasSecondaryPrice;
use Src\Products\Domain\Models\Post\Post;
use Src\Products\Domain\Models\Product\Contracts\Product;

/*
 * @deprecated
 */
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
        $price = $post->getCalculatedPrice();
        $store = $post->getMarketplace();
        $commissionRate = $price->getCommission()->getCommissionRate();
        $commission = Percentage::fromFraction($commissionRate)->get();

        return [
            'name' => $product->getDetails()->getName(),
            'sku' => $product->getSku(),
            'id' => $post->getId(),
            'store' => $store->getName(),
            'marketplaceSlug' => $store->getSlug(),
            'mainPrice' => [
                'value' => MoneyTransformer::toFloat($price->get()),
                'profit' => MoneyTransformer::toFloat($price->getProfit()),
                'margin' => $price->getMargin(),
                'commission' => $commission,
            ],
        ];
    }

    private function presentNew(Post $post): array
    {

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
