<?php

namespace Src\Costs\Infrastructure\Laravel\Presenters;

use Src\Costs\Domain\Models\PurchaseItem;
use Src\Math\Transformers\NumberTransformer;
use Src\Math\Percentage;

class PurchaseItemsPresenter
{
    public function present(PurchaseItem $item): array
    {
        return [
            'issuedAt' => $item->getIssuedAt()->format('d/m/Y H:i'),
            'name' => $item->getName(),
            'purchasePrice' => NumberTransformer::toMoney($item->getUnitPrice()),
            'unitCost' => NumberTransformer::toMoney($item->getUnitCost()),
            'quantity' => $item->getQuantity(),
            'totalValue' => NumberTransformer::toMoney($item->getTotalValue()),
            'purchaseItemUuid' => $item->getPurchaseItemUuid(),
            'productSku' => $item->getProductSku(),
            'costs' => [
                'purchasePrice' => NumberTransformer::toMoney($item->getUnitPrice()),
                'taxes' => NumberTransformer::toMoney($item->getTotalTaxesCosts()),
                'freight' => NumberTransformer::toMoney($item->getFreightCosts()),
                'insurance' => NumberTransformer::toMoney($item->getInsuranceCosts()),
                'icms' => NumberTransformer::toPercentage(
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
