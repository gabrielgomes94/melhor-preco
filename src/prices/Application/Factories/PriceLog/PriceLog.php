<?php

namespace Src\Prices\Application\Factories\PriceLog;

use Src\Products\Domain\Models\Product as ProductModel;
use Src\Prices\Domain\PriceLog\Product;

class PriceLog
{
    public static function buildProduct(ProductModel $product): Product
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
