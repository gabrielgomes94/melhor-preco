<?php

namespace Src\Costs\Infrastructure\NFe\Mappers;

use Src\Costs\Infrastructure\NFe\Data\Product;
use Src\Costs\Infrastructure\NFe\Services\CalculateUnitCost;

class PurchaseItemMapper
{
    public function map(Product $product): array
    {
        return [
            'name' => $product->name,
            'unit_price' => $product->price,
            'quantity' => $product->quantity,
            'freight_cost' => $product->getUnitFreightValue(),
            'insurance_cost' => $product->getUnitInsuranceValue(),
            'discount' => $product->discount,
            'ean' => $product->ean,
            'taxes' => $product->taxes->toArray(),
        ];
    }
}
