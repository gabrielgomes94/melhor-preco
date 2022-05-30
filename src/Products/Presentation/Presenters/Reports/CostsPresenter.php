<?php

namespace Src\Products\Presentation\Presenters\Reports;

use Illuminate\Support\Collection;
use Src\Costs\Infrastructure\Laravel\Models\PurchaseItem;
use Src\Math\MathPresenter;
use Src\Math\Percentage;

class CostsPresenter
{
    public function present(Collection $costs)
    {
        $items = $costs->map(function (PurchaseItem $item) {

//            dd(MathPresenter::money($item->getFreightCosts()));

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
