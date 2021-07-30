<?php

namespace Integrations\Bling\Products\Transformers;

use Integrations\Bling\Products\Data\Product as ProductData;

class ProductWithStore
{
    public static function transform(array $data, string $storeCode): ?ProductData
    {
        if (!isset($data)) {
            return null;
        }

        $product = Product::transform($data);
        $product->addStore(Store::transform($data, $storeCode));

        return $product;
    }
}
