<?php

namespace App\Factories\Pricing\PriceLog;

use App\Models\Product as ProductModel;
use Barrigudinha\Pricing\PriceLog\Entities\Product;

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
