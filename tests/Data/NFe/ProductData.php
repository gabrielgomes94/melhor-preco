<?php

namespace Tests\Data\NFe;

use Src\Costs\Infrastructure\NFe\Data\Product;

class ProductData
{
    public static function make(): Product
    {
        return Product::fromArray(ItemData::getNFeItem());
    }
}
