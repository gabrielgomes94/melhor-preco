<?php

namespace Src\Prices\PriceList\Infrastructure\Repositories\Product\Filters;

use Src\Prices\PriceList\Infrastructure\Repositories\Product\Filters\Contracts\Filter;
use Src\Products\Domain\Entities\ProductsCollection;
use Src\Products\Domain\Contracts\Utils\Options;

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
