<?php

namespace App\Repositories\Pricing\Product\Filters;

use Barrigudinha\Product\Entities\ProductsCollection;
use Barrigudinha\Product\Repositories\Contracts\Options;

class Kit
{
    public static function execute(ProductsCollection $productsCollection, Options $options): ProductsCollection
    {
        if (!$options->filterKits()) {
            return $productsCollection;
        }

        foreach ($productsCollection as $product) {
            if ($product->hasCompositionProducts()) {
                $kits[] = $product;
            }
        };

        return new ProductsCollection($kits ?? []);
    }
}
