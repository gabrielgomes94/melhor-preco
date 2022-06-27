<?php

namespace Src\Products\Infrastructure\Laravel\Presenters;

use Src\Math\MathPresenter;
use Src\Products\Domain\DataTransfer\ProductInfoReport;
use Src\Products\Infrastructure\Laravel\Presenters\ProductPresenter;
use Src\Sales\Application\Data\MarketplaceSaleItems;
use Src\Sales\Application\Data\Reports\SalesReport;
use Src\Sales\Domain\Models\Item;

class ProductReportPresenter
{
    public function __construct(
        private PricePresenter $pricePresenter,
        private ProductPresenter $productPresenter,
        private CostsPresenter $costsPresenter
    ) {
    }

    public function present(ProductInfoReport $productInfoReport): array
    {
        $salesReport = $productInfoReport->salesReport;
        $costs = $this->costsPresenter->present($productInfoReport->costsItems);

        return [
            'costs' => $costs,
            'prices' => $this->pricePresenter->present($productInfoReport->product),
            'product' => $this->productPresenter->present($productInfoReport->product),
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

            if (!$saleOrder) {
                return [
                    'saleDate' => null,
                    'marketplace' => null,
                    'quantity' => null,
                    'value' => null,
                ];
            }

            $value = $saleOrder->getSaleValue()->totalValue();

            return [
                'saleDate' => $saleOrder->getSelledAt()->format('d/m/Y'),
                'marketplace' => $saleOrder->getMarketplace()?->getName(),
                'quantity' => $saleItem->getQuantity(),
                'value' => MathPresenter::money($value),
            ];
        });

        return $sales->toArray();
    }

    private function getSalesByMarketplace(SalesReport $salesReport): array
    {
        $marketplaceSales = $salesReport->salesInMarketplaces->marketplacesSales;

        $marketplaceSales = $marketplaceSales->transform(function (MarketplaceSaleItems $marketplaceSales) {
            $sales = $marketplaceSales->sales->get();
            $totalValue = $sales->sum(function (Item $saleItem) {
                return $saleItem->getTotalValue();
            });

            return [
                'quantity' => $sales->count(),
                'value' => MathPresenter::money($totalValue),
                'slug' => $marketplaceSales->marketplace->getSlug(),
                'storeName' => $marketplaceSales->marketplace->getName(),
            ];
        });

        return $marketplaceSales->toArray();
    }

    private function getTotalSales(SalesReport $salesReport): array
    {
        $itemsSelled = $salesReport->itemsSelled->get();
        $totalValue = $itemsSelled->sum(function (Item $saleItem) {
            return $saleItem->getTotalValue();
        });

        return [
            'quantity' => $itemsSelled->count(),
            'value' => MathPresenter::money($totalValue),
        ];
    }
}
