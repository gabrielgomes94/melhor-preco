<?php

namespace Integrations\Bling\Products\Responses\Transformers;

use Integrations\Bling\Products\Responses\Data\ProductStore as ProductStoreData;

class ProductStore
{
    public static function transform(array $data, string $storeSlug)
    {
        $sku = Product::transform($data)->sku();
        $store = Store::transform($data, $storeSlug);

        return new ProductStoreData($sku, $store);
    }
}
