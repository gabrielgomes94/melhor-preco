<?php

namespace App\Presenters\Pricing\Product;

use Barrigudinha\Pricing\PostPriced;
use Barrigudinha\Product\Product as ProductData;

class Presenter
{
    public function singleProduct(ProductData $product): Product
    {
        return new Product($product);
    }

    /**
     * @param PostPriced[] $postsPriced
     * @return Post[]
     */
    public function prices(array $postsPriced): array
    {
        foreach ($postsPriced as $post) {
            $pricePresentation[] = new Post($post);
        }

        return $pricePresentation ?? [];
    }
}
