<?php

namespace Barrigudinha\Product\Services;

use Barrigudinha\Pricing\Services\PriceCalculator\Calculate;
use Barrigudinha\Product\Data\Costs;
use Barrigudinha\Product\Post;
use Barrigudinha\Product\Product;

class Update
{
    private Calculate $service;

    public function __construct(Calculate $service)
    {
        $this->service = $service;
    }

    public function updateCosts(Product $product, array $data): Product
    {
        $costs = new Costs(
            purchasePrice: $data['purchasePrice'] ?? $product->costs()->purchasePrice(),
            additionalCosts: $data['additionalCosts'] ?? $product->costs()->additionalCosts(),
            taxICMS: $data['taxICMS'] ?? $product->costs()->taxICMS(),
        );
        $product->setCosts($costs);

        foreach ($product->posts() as $post) {
            $post->setProfit($this->calculateProfit($product, $post));
        }

        return $product;
    }

    private function calculateProfit(Product $product, Post $post)
    {
        $calculatedPrice = $this->service->calculate(
            product: $product,
            store: $post->store()->code(),
            desiredPrice: $post->price(),
            commission: $post->store()->commission(),
        );

        return $calculatedPrice->price()->profit();
    }
}
