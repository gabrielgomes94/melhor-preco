<?php

namespace Src\Costs\Infrastructure\Laravel\Repositories\Mappers;

use Src\Costs\Domain\UseCases\CalculateUnitCost;
use Src\Costs\Infrastructure\NFe\XmlReader;

class PurchaseItemTransformer
{
    private XmlReader $nfeReader;
    private CalculateUnitCost $calculateUnitCost;

    public function __construct(
        XmlReader $nfeReader,
        CalculateUnitCost $calculateUnitCost
    ) {
        $this->nfeReader = $nfeReader;
        $this->calculateUnitCost = $calculateUnitCost;
    }

    public function transform(array $item): array
    {
        $product = $this->nfeReader->getProductData($item);
        $unitCost = $this->calculateUnitCost->calculate($item);

        return [
            'name' => $this->nfeReader->getName($product),
            'unit_price' => $this->nfeReader->getPrice($product),
            'unit_cost' => $unitCost,
            'quantity' => $this->nfeReader->getQuantity($product),
            'freight_cost' => $this->nfeReader->getFreightValue($product),
            'insurance_cost' => $this->nfeReader->getInsuranceValue($product),
            'discount' => $this->nfeReader->getDiscount($product),
            'taxes' => $this->nfeReader->getTaxes($item),
            'ean' => $this->nfeReader->getEan($product),
        ];
    }
}
