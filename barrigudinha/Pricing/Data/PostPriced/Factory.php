<?php

namespace Barrigudinha\Pricing\Data\PostPriced;

use Barrigudinha\Pricing\Price\Price;
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

        if ($store === 'mercado_livre') {
            return new MercadoLivrePostPriced($post, $price, $product, $options);
        }

        return new PostPriced($post, $price, $product, $options);
    }
}
