<?php

namespace App\Presenters\Pricing\Product;

use App\Presenters\Pricing\Post\Factory as PostPresenterFactory;
use App\Presenters\Pricing\Post\Post;
use Src\Prices\Domain\Factories\PostPriced\Factory;
use Barrigudinha\Pricing\Data\PostPriced\PostPriced;
use Barrigudinha\Product\Entities\Product as ProductData;
use Barrigudinha\Product\Entities\ProductsCollection;

class Presenter
{
    public function singleProduct(ProductData $product): Product
    {
        return new Product($product);
    }

    /**
     * @param ProductData[] $post
     * @return array
     */
    public function list(ProductsCollection $products, string $store = null): array
    {
        foreach ($products as $product) {
            $presentedProducts[] = new Product($product, $store);
        }

        return $presentedProducts ?? [];
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
