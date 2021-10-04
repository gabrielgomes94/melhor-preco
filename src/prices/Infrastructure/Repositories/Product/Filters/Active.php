<?php

namespace Src\Prices\Infrastructure\Repositories\Product\Filters;

use Src\Prices\Infrastructure\Repositories\Product\Filters\Contracts\Filter;
use Barrigudinha\Product\Entities\ProductsCollection;
use Barrigudinha\Product\Utils\Contracts\Options;

class Active implements Filter
{
    public static function execute(ProductsCollection $productsCollection, Options $options): ProductsCollection
    {
        foreach ($productsCollection as $product) {
            if (empty($product->posts())) {
                continue;
            }

            $activeProducts[] = $product;
        }

        return new ProductsCollection($activeProducts ?? []);
    }
}
