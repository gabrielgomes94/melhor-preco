<?php

namespace Barrigudinha\Pricing\Services\PriceCalculator;

use Barrigudinha\Pricing\Data\PostPriced\PostPriced;
use Barrigudinha\Product\Product;

class CalculateList
{
    public Calculate $calculateService;

    public function __construct(Calculate $calculateService)
    {
        $this->calculateService = $calculateService;
    }

    /**
     * @var Product[] $products
     * @return PostPriced[]
     */
    public function execute(array $products, string $store): array
    {
        foreach ($products as $product) {
            if (!$post = $product->post($store)) {
                continue;
            }

            $productsPriced[] = $this->calculateService->calculate($product, $store, $post->price(), $post->store()->commission());
        }

        return $productsPriced ?? [];
    }
}
