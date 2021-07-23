<?php

namespace Barrigudinha\Pricing\Price\Services;

use Barrigudinha\Pricing\Price\Services\Contracts\CalculateProduct as CalculateProductInterface;
use Barrigudinha\Product\Product;

class CalculateProduct implements CalculateProductInterface
{
    private CalculatePrice $calculatePrice;

    public function __construct(CalculatePrice $calculatePrice)
    {
        $this->calculatePrice = $calculatePrice;
    }

    public function recalculate(Product $product): Product
    {
        foreach ($product->posts() as $post) {
            $price = $this->calculatePrice->recalculate($product, $post->store());
            $post->setProfit($price->profit());

            $posts[] = $post;
        }

        $product->setPosts($posts ?? []);

        return $product;
    }
}
