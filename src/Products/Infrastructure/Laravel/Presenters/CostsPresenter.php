<?php

namespace Src\Products\Infrastructure\Laravel\Presenters;

use Illuminate\Support\Collection;
use Src\Costs\Infrastructure\Laravel\Models\PurchaseItem;
use Src\Math\MathPresenter;
use Src\Math\Percentage;

// @todo: mover para o contexto de custos.
// Mergear essa classe com o PurchaseItemsPresenter para ter apenas um presenter sendo usado na aplicação
class CostsPresenter
{
    public function present(array $costs)
    {
        $costs = collect($costs);

        $items = $costs->map(function (PurchaseItem $item) {
            return [
                'issuedAt' => $item->getIssuedAt()->format('d/m/Y H:i'),
                'unitCost' => MathPresenter::money($item->getUnitCost()),
                'costs' => [
                    'purchasePrice' => MathPresenter::money($item->getUnitPrice()),
                    'taxes' => MathPresenter::money($item->getTotalTaxesCosts()),
                    'freight' => MathPresenter::money($item->getFreightCosts()),
                    'insurance' => MathPresenter::money($item->getInsuranceCosts()),
                    'icms' => MathPresenter::percentage(
                        Percentage::fromPercentage($item->getICMSPercentage())
                    ),
                ],
                'quantity' => $item->getQuantity(),
                'supplierName' => $item->getSupplierName(),
                'supplierFiscalId' => $item->getSupplierFiscalId(),
            ];
        })->toArray();


        return $items;
    }
}
