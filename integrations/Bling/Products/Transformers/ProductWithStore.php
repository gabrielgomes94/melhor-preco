<?php

namespace Integrations\Bling\Products\Transformers;

class ProductWithStore
{
    public static function transform(array $data, string $storeCode)
    {
        if (!isset($data)) {
            return [];
        }

        $product = Product::transform($data);
        $product['store'] = Store::transform($data, $storeCode);

        return $product;
    }
}
