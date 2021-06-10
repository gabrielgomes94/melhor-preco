<?php

namespace Barrigudinha\Pricing\Services\PriceCalculator;

use App\Presenters\Pricing\Product\Post;
use Barrigudinha\Pricing\Data\Price;
use Barrigudinha\Pricing\PostPriced;
use Barrigudinha\Product\Product;

class ProductCalculator
{
    /**
     * @return PostPriced[]
     */
    public function execute(Product $product): array
    {
        foreach ($product->posts() as $post) {
            $price = new Price($product, $post->price(), $post->store()->slug());
            $posts[] = new PostPriced($post, $price, $product);
        }

        return $posts ?? [];
    }
}
