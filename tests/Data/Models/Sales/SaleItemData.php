<?php

namespace Tests\Data\Models\Sales;

use Src\Products\Infrastructure\Laravel\Models\Product\Product;
use Src\Sales\Infrastructure\Laravel\Models\Item;

class SaleItemData
{
    public static function make(Product $product)
    {
        $item = new Item([
            'sku' => $product->getSku(),
            'name' => $product->getName(),
            'quantity' => $data['quantity'] ?? 1,
            'unit_value' => $data['unitValue'] ?? 100.0,
            'discount' => $data['discount'] ?? 0.0,
        ]);

        $item->product()->associate($product);

        return $item;
    }
}
