<?php

namespace Barrigudinha\Pricing\Services\PriceCalculator;

use Barrigudinha\Pricing\Data\PostPriced\Factory as PostPricedFactory;
use Barrigudinha\Pricing\Data\Price;
use Barrigudinha\Pricing\Data\PostPriced\PostPriced;
use Barrigudinha\Product\Product;

class ProductCalculator
{
    /**
     * @return PostPriced[]
     */
    public function execute(Product $product, array $stores): array
    {
        foreach ($product->posts() as $post) {
            $store = $post->store()->slug();

            if (in_array($store, $stores)) {
                $price = new Price($product, $post->price(), $post->store()->slug());
                $posts[] = PostPricedFactory::make($post, $price, $product);
            }
        }

        return $posts ?? [];
    }
}
