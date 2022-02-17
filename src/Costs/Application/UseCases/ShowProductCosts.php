<?php

namespace Src\Costs\Application\UseCases;

use Illuminate\Support\Collection;
use Src\Costs\Domain\Models\PurchaseItem;
use Src\Products\Domain\Repositories\Contracts\ProductRepository;

class ShowProductCosts
{
    private ProductRepository $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function show(string $sku): Collection
    {
        if (!$product = $this->repository->get($sku)) {
            return collect([]);
        }

        $items = $product->itemsCosts;

        $items = $items->sortByDesc(function(PurchaseItem $item) {
            return $item->getIssuedAt();
        });

        $items = $items->map(function(PurchaseItem $item) {
            return [
                'issuedAt' => $item->getIssuedAt()->format('d-m-Y H:i'),
                'unitCost' => $item->getUnitCost(),
                'costs' => [
                    'purchasePrice' => $item->getUnitPrice(),
                    'taxes' => $item->getTotalTaxesCosts(),
                    'freight' => $item->getFreightCosts(),
                    'insurance' => $item->getInsuranceCosts(),
                    'icms' => $item->getICMSPercentage(),
                ],
                'quantity' => $item->getQuantity(),
                'supplierName' => $item->getSupplierName(),
                'supplierFiscalId' => $item->getSupplierFiscalId(),
            ];
        });

        return $items;
    }
}
