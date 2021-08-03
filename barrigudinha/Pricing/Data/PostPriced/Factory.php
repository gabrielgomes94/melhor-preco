<?php

namespace Barrigudinha\Pricing\Data\PostPriced;

use Barrigudinha\Pricing\Data\Price;
use Barrigudinha\Product\Entities\Post;
use Barrigudinha\Product\Entities\Product;

class Factory
{
    public static function make(Post $post, Price $price, Product $product, array $options = []): PostPriced
    {
        $store = $post->store()->slug();

        if ($store === 'magalu') {
            return new MagaluPostPriced($post, $price, $product, $options);
        }

        return new PostPriced($post, $price, $product, $options);
    }
}
