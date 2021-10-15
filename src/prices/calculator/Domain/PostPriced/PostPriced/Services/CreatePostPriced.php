<?php

namespace Src\Prices\Calculator\Domain\PostPriced\Services;

use Src\Prices\Calculator\Domain\Contracts\Services\PostPriced\CreatePostPricedService;
use Src\Prices\Calculator\Domain\PostPriced\Factory;
use Src\Prices\Calculator\Domain\PostPriced\PostPriced;
use Src\Prices\Calculator\Domain\Services\CalculatePrice;
use Src\Products\Domain\Entities\Product;
use Src\Products\Domain\Data\Store;
use Money\Money;

/**
 * @deprecated
 * Class CreatePostPriced
 * @package Src\Prices\Domain\PostPriced\Services
 */
class CreatePostPriced implements CreatePostPricedService
{
    private \Src\Prices\Calculator\Domain\Services\CalculatePrice $calculatePrice;

    public function __construct(\Src\Prices\Calculator\Domain\Services\CalculatePrice $calculatePrice)
    {
        $this->calculatePrice = $calculatePrice;
    }

    public function create(Product $product, Store $store, ?Money $price = null, array $options = []): PostPriced
    {
        $price = $this->getPrice($product, $store->slug(), $price);
        $price = $this->calculatePrice->calculate($product, $store, $price, $options);
        $post = $product->getPost($store->slug());

        return Factory::make($post, $price, $product, $options);
    }

    /**
     * @param Product $product
     * @param \Src\Products\Domain\Data\Store[] $stores
     * @return PostPriced[]
     */
    public function createList(Product $product, array $stores): array
    {
        foreach ($product->posts() as $post) {
            $store = $post->store();

            if (in_array($store, $stores)) {
                $price = $this->getPrice($product, $store->slug());
                $price = $this->calculatePrice->calculate($product, $store, $price);
                $posts[] = Factory::make($post, $price, $product);
            }
        }

        return $posts ?? [];
    }


    private function getPrice(Product $product, string $store, ?Money $price = null): Money
    {
        if (!$price) {
            return $product->getPost($store)->price();
        }

        return $price;
    }
}
