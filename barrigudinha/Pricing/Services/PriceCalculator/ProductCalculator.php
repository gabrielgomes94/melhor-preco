<?php

namespace Barrigudinha\Pricing\Services\PriceCalculator;

use Barrigudinha\Pricing\Data\PostPriced\Factory as PostPricedFactory;
use Barrigudinha\Pricing\Data\Price;
use Barrigudinha\Pricing\Data\PostPriced\PostPriced;
use Barrigudinha\Product\Product;
use App\Repositories\Store\Store as StoreRepository;

class ProductCalculator
{
    private StoreRepository $storeRepository;

    public function __construct(StoreRepository $storeRepository)
    {
        $this->storeRepository = $storeRepository;
    }


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

    public function single(Product $product, string $store): PostPriced
    {
        $post = $product->post($store);
        $commission = $this->storeRepository->commission($store);

        $price = new Price($product, $post->price(), $store, null, $commission);

        return PostPricedFactory::make($post, $price, $product);
    }
}
