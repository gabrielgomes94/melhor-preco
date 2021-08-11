<?php

namespace App\Repositories\Pricing\Product\Filters;

use App\Repositories\Pricing\Product\Filters\Contracts\Filter;
use Barrigudinha\Product\Entities\ProductsCollection;
use Barrigudinha\Product\Repositories\Contracts\Options;

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
