<?php

namespace App\Presenters\Pricing\Product;

use App\Presenters\Pricing\Post\Factory as PostPresenterFactory;
use App\Presenters\Pricing\Post\Post;
use Barrigudinha\Pricing\Data\PostPriced\Factory;
use Barrigudinha\Pricing\Data\PostPriced\PostPriced;
use Barrigudinha\Product\Product as ProductData;

class Presenter
{
    public function singleProduct(ProductData $product): Product
    {
        return new Product($product);
    }

    /**
     * @param PostPriced[] $posts
     * @return array
     */
    public function listPriced(array $posts): array
    {
        foreach ($posts as $post) {
            $productsPresentation[] = PostPresenterFactory::make($post);
        }

        return $productsPresentation ?? [];
    }

    /**
     * @param PostPriced[] $postsPriced
     * @return Post[]
     */
    public function prices(array $postsPriced): array
    {
        foreach ($postsPriced as $post) {
            $pricePresentation[] = PostPresenterFactory::make($post);
        }

        return $pricePresentation ?? [];
    }
}
