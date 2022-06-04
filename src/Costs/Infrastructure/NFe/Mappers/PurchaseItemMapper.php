<?php

namespace Src\Costs\Infrastructure\NFe\Mappers;

use Src\Costs\Infrastructure\NFe\Data\Product;
use Src\Costs\Infrastructure\NFe\Services\CalculateUnitCost;

class PurchaseItemMapper
{
    public function __construct(
        private CalculateUnitCost $calculateUnitCostService
    ) {
    }

    public function map(Product $product): array
    {
        $unitCost = $this->calculateUnitCostService->calculate($product);

        return [
            'name' => $product->name,
            'unit_price' => $product->price,
            'unit_cost' => $unitCost,
            'quantity' => $product->quantity,
            'freight_cost' => $product->getUnitFreightValue(),
            'insurance_cost' => $product->getUnitInsuranceValue(),
            'discount' => $product->discount,
            'ean' => $product->ean,
            'taxes' => $product->taxes->toArray(),
        ];
    }
}
