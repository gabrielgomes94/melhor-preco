<?php

namespace Src\Integrations\Bling\Products\Responses\Transformers;

use Src\Integrations\Bling\Products\Responses\Transformers\Store;
use Src\Integrations\Bling\Products\Responses\Data\ProductStore as ProductStoreData;
use Src\Integrations\Bling\Products\Responses\Transformers\Product;

class ProductStore
{
    public static function transform(array $data, string $storeSlug)
    {
        $sku = Product::transform($data)->sku();
        $store = Store::transform($data, $storeSlug);

        return new ProductStoreData($sku, $store);
    }
}
