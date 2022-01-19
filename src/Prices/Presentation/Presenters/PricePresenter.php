<?php

namespace Src\Prices\Presentation\Presenters;

use Src\Calculator\Domain\Transformer\MoneyTransformer;
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
        return [
            'name' => $product->getDetails()->getName(),
            'sku' => $product->getSku(),
            'id' => $post->getId(),
            'store' => $post->getStore()->getName(),
            'storeSlug' => $post->getStore()->getSlug(),
            'mainPrice' => [
                'value' => MoneyTransformer::toFloat($post->getPrice()->get()),
                'profit' => MoneyTransformer::toFloat($post->getPrice()->getProfit()),
                'margin' => $post->getPrice()->getMargin(),
                'commission' => MoneyTransformer::toFloat($post->getPrice()->getCommission()->get()),
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
