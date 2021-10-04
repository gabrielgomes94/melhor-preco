<?php

namespace Src\Prices\Infrastructure\Repositories\Product\Filters;

use Barrigudinha\Product\Entities\ProductsCollection;
use Barrigudinha\Product\Utils\Contracts\Options;

class MarginRange
{
    public static function execute(ProductsCollection $productsCollection, Options $options): ProductsCollection
    {
        if (!$options->hasProfitFilters()) {
            return $productsCollection;
        }

        foreach ($productsCollection as $product) {
            $post = $product->post($options->store());

            if ($post->isInMarginRange($options->minimumProfit(), $options->maximumProfit())) {
                $filteredProducts[] = $product;
            }
        };

        return new ProductsCollection($filteredProducts ?? []);
    }
}
