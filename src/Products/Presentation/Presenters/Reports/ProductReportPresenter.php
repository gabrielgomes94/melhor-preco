<?php

namespace Src\Products\Presentation\Presenters\Reports;

use Src\Products\Application\Data\Reports\ProductInfoReport;
use Src\Sales\Application\Data\MarketplaceSaleItems;
use Src\Sales\Application\Data\Reports\SalesReport;
use Src\Sales\Domain\Models\Item;

class ProductReportPresenter
{
    public function present(ProductInfoReport $productInfoReport)
    {
        $salesReport = $productInfoReport->salesReport;

        return [
            'costs' => $productInfoReport->costsItems->toArray(),
            'product' => $productInfoReport->product->toArray(),
            'sales' => [
                'lastSales' => $this->getLastSales($salesReport),
                'salesByMarketplace' => $this->getSalesByMarketplace($salesReport),
                'total' => $this->getTotalSales($salesReport),
            ]
        ];
    }

    private function getLastSales(SalesReport $salesReport): array
    {
        $sales = $salesReport->lastSales->get();
        $sales = $sales->transform(function (Item $saleItem) {
            $saleOrder = $saleItem->getSaleOrder();

            return [
                'saleDate' => $saleOrder->getSelledAt(),
                'marketplace' => $saleOrder->getMarketplace()?->getName(),
                'quantity' => $saleItem->getQuantity(),
                'value' => $saleOrder->getSaleValue()->totalValue(),
            ];
        });

        return $sales->toArray();
    }

    private function getSalesByMarketplace(SalesReport $salesReport): array
    {
        $marketplaceSales = $salesReport->salesInMarketplaces->marketplacesSales;

        $marketplaceSales = $marketplaceSales->transform(function (MarketplaceSaleItems $marketplaceSales) {
            $sales = $marketplaceSales->sales->get();

            return [
                'quantity' => $sales->count(),
                'value' => $sales->sum(function (Item $saleItem) {
                    return $saleItem->getTotalValue();
                }),
                'slug' => $marketplaceSales->marketplace->getSlug(),
                'storeName' => $marketplaceSales->marketplace->getName(),
            ];
        });

        return $marketplaceSales->toArray();
    }

    private function getTotalSales(SalesReport $salesReport): array
    {
        $itemsSelled = $salesReport->itemsSelled->get();

        return [
            'quantity' => $itemsSelled->count(),
            'value' => $itemsSelled->sum(function (Item $saleItem) {
                return $saleItem->getTotalValue();
            }),
        ];
    }
}
