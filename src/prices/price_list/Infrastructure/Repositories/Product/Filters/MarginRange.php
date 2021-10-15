<?php

namespace Src\Prices\PriceList\Infrastructure\Repositories\Product\Filters;

use Src\Products\Domain\Entities\ProductsCollection;
use Src\Products\Domain\Contracts\Utils\Options;

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
