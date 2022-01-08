<?php

namespace Src\Costs\Presentation\Presenters;

use Src\Costs\Domain\Models\PurchaseItem;

class PurchaseItemsPresenter
{
    public static function present(PurchaseItem $item)
    {
        return [
            'name' => $item->getName(),
            'purchasePrice' => $item->getUnitPrice(),
            'additionalCosts' => [
                'freightValue' => $item->getFreightCosts(),
                'taxesValue' => $item->getTotalTaxesCosts(),
                'insuranceValue' => $item->getInsuranceCosts(),
            ],
            'unitValue' => $item->getUnitCost(),
            'quantity' => $item->getQuantity(),
            'totalValue' => $item->getTotalValue(),
            'purchaseItemUuid' => $item->getPurchaseItemUuid(),
            'productSku' => $item->getProductSku(),
        ];
    }
}
