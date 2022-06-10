<?php

namespace Src\Costs\Infrastructure\Laravel\Presenters;

use Src\Costs\Infrastructure\Laravel\Models\PurchaseItem;
use Src\Math\MathPresenter;

class PurchaseItemsPresenter
{
    public static function present(PurchaseItem $item): array
    {
        return [
            'name' => $item->getName(),
            'purchasePrice' => MathPresenter::money($item->getUnitPrice()),
            'additionalCosts' => [
                'freightValue' => MathPresenter::money($item->getFreightCosts()),
                'taxesValue' => MathPresenter::money($item->getTotalTaxesCosts()),
                'insuranceValue' => MathPresenter::money($item->getInsuranceCosts()),
            ],
            'unitValue' => MathPresenter::money($item->getUnitCost()),
            'quantity' => $item->getQuantity(),
            'totalValue' => MathPresenter::money($item->getTotalValue()),
            'purchaseItemUuid' => $item->getPurchaseItemUuid(),
            'productSku' => $item->getProductSku(),
        ];
    }
}
