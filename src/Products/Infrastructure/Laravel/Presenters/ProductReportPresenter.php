<?php

namespace Src\Products\Infrastructure\Laravel\Presenters;

use Src\Costs\Domain\Models\PurchaseItem;
use Src\Costs\Infrastructure\Laravel\Presenters\PurchaseItemsPresenter;
use Src\Math\MathPresenter;
use Src\Products\Domain\DataTransfer\ProductInfoReport;
use Src\Sales\Domain\DataTransfer\Reports\Marketplaces\MarketplaceSales;
use Src\Sales\Domain\DataTransfer\Reports\Products\ProductReport;
use Src\Sales\Infrastructure\Laravel\Models\Item;

class ProductReportPresenter
{
    public function __construct(
        private PricePresenter $pricePresenter,
        private ProductPresenter $productPresenter,
        private PurchaseItemsPresenter $purchaseItemsPresenter
    ) {
    }

    public function present(ProductInfoReport $productInfoReport): array
    {
        $salesReport = $productInfoReport->salesReport;
        $costs = collect($productInfoReport->costsItems);
        $costs = $costs->map(function(PurchaseItem $item) {
            return $this->purchaseItemsPresenter->present($item);
        });

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

    private function getLastSales(ProductReport $salesReport): array
    {
        $sales = $salesReport->lastSales->get();
        $sales = collect($sales);
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

    private function getSalesByMarketplace(ProductReport $salesReport): array
    {
        $marketplaceSales = $salesReport->salesInMarketplaces->marketplacesSales;

        $marketplaceSales = $marketplaceSales->transform(function (MarketplaceSales $marketplaceSales) {
            $sales = $marketplaceSales->sales->get();
            $sales = collect($sales);
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

    private function getTotalSales(ProductReport $salesReport): array
    {
        $itemsSelled = $salesReport->lastSales?->get();
        $itemsSelled = collect($itemsSelled);

        $totalValue = $itemsSelled->sum(function (Item $saleItem) {
            return $saleItem->getTotalValue();
        });

        return [
            'quantity' => $itemsSelled->count(),
            'value' => MathPresenter::money($totalValue),
        ];
    }
}
