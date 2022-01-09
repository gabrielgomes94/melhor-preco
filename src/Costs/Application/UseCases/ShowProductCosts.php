<?php

namespace Src\Costs\Application\UseCases;

use Src\Costs\Domain\Models\PurchaseItem;
use Src\Products\Domain\Repositories\Contracts\ProductRepository;

class ShowProductCosts
{
    private ProductRepository $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function show(string $sku)
    {
        if (!$product = $this->repository->get($sku)) {
            return null;
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

        return [
            'product' => [
                'sku' => $product->getSku(),
                'name' => $product->getDetails()->getName(),
            ],
            'items' => $items,
        ];
    }
}
