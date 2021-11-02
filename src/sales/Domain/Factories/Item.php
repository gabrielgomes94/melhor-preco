<?php

namespace Src\Sales\Domain\Factories;

use Src\Sales\Domain\Models\Data\Items\Item as ItemData;
use Src\Sales\Domain\Models\Item as ItemModel;

class Item
{
    public static function make(ItemModel $item)
    {
        return new ItemData(
            sku: $item->sku,
            name: $item->name,
            quantity: $item->quantity,
            unitValue: $item->unit_value,
            discount: $item->discount,
        );
    }

    public static function makeModel(ItemData $item)
    {
        return new ItemModel([
            'sku' => $item->sku(),
            'name' => $item->name(),
            'quantity' => $item->quantity(),
            'unit_value' => $item->unitValue(),
            'discount' => $item->discount(),
        ]);
    }
}
