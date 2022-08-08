<?php

namespace Src\Costs\Infrastructure\Laravel\Presenters;

use Src\Costs\Domain\Models\Contracts\PurchaseItem;
use Src\Math\MathPresenter;
use Src\Math\Percentage;

class PurchaseItemsPresenter
{
    public function present(PurchaseItem $item): array
    {
        return [
            'issuedAt' => $item->getIssuedAt()->format('d/m/Y H:i'),

            'name' => $item->getName(),
            'purchasePrice' => MathPresenter::money($item->getUnitPrice()),
            'unitCost' => MathPresenter::money($item->getUnitCost()),
            'quantity' => $item->getQuantity(),
            'totalValue' => MathPresenter::money($item->getTotalValue()),
            'purchaseItemUuid' => $item->getPurchaseItemUuid(),
            'productSku' => $item->getProductSku(),
            'costs' => [
                'purchasePrice' => MathPresenter::money($item->getUnitPrice()),
                'taxes' => MathPresenter::money($item->getTotalTaxesCosts()),
                'freight' => MathPresenter::money($item->getFreightCosts()),
                'insurance' => MathPresenter::money($item->getInsuranceCosts()),
                'icms' => MathPresenter::percentage(
                    Percentage::fromPercentage($item->getICMSPercentage())
                ),
            ],
            'supplier' => [
                'name' => $item->getSupplierName(),
                'fiscalId' => $item->getSupplierFiscalId(),
            ],
        ];
    }

    public function presentList(array $purchaseItems = []): array
    {
        $purchaseItems = collect($purchaseItems);

        return $purchaseItems->transform(
            function(PurchaseItem $item) {
                return $this->present($item);
            }
            )->all();
    }
}
