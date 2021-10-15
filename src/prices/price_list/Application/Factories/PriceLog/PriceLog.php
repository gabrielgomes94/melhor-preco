<?php

namespace Src\Prices\PriceList\Application\Factories\PriceLog;

use Src\Products\Domain\Models\Product as ProductModel;
use Src\Prices\PriceList\Domain\PriceLog\Product;

class PriceLog
{
    public static function buildProduct(ProductModel $product): \Src\Prices\PriceList\Domain\PriceLog\Product
    {
        return new Product(
            sku: $product->sku,
            store: $product->store,
            name: $product->name,
            price: $product->value,
            profit: $product->profit,
            updatedAt: $product->updated_at
        );
    }
}
