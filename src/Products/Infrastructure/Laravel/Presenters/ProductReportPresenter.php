<?php

namespace Src\Products\Infrastructure\Laravel\Presenters;

use Src\Costs\Domain\Models\PurchaseItem;
use Src\Costs\Infrastructure\Laravel\Presenters\PurchaseItemsPresenter;
use Src\Math\Transformers\NumberTransformer;
use Src\Products\Domain\DataTransfer\ProductInfoReport;
use Src\Sales\Application\Reports\Data\Marketplace\MarketplaceSales;
use Src\Sales\Domain\DataTransfer\Reports\Products\ProductReport;
use Src\Sales\Domain\Reports\Product\ProductSales;
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
        $salesReport = $productInfoReport->productSales;

        $costs = collect($productInfoReport->costsItems);
        $costs = $costs->map(function (PurchaseItem $item) {
            return $this->purchaseItemsPresenter->present($item);
        })->all();

        return [
            'costs' => $costs,
            'prices' => $this->pricePresenter->present($productInfoReport->product),
            'product' => $this->productPresenter->present($productInfoReport->product),
            'sales' => [
                'lastSales' => $this->getLastSales($salesReport),
                'salesByMarketplace' => $this->getSalesByMarketplace($productInfoReport),
                'total' => $this->getTotalSales($salesReport),
            ]
        ];
    }

    private function getLastSales(ProductSales $salesReport): array
    {
        $lastSales = $salesReport->getLastSales()->get();
        $lastSales = collect($lastSales);

        $lastSales = $lastSales->transform(function (Item $saleItem) {
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
                'value' => NumberTransformer::toMoney($value),
            ];
        });

        return $lastSales->toArray();
    }

    private function getSalesByMarketplace(ProductInfoReport $productInfoReport): array
    {
        $marketplaceSales = $productInfoReport->marketplaceSales;
        $marketplaceSales = collect($marketplaceSales);

        $marketplaceSales = $marketplaceSales->sortBy(function (MarketplaceSales $marketplaceSales) {
        })->transform(function (MarketplaceSales $marketplaceSales) {

            return [
                'quantity' => $marketplaceSales->getSalesCount(),
                'value' => NumberTransformer::toMoney($marketplaceSales->getTotalValue()),
                'slug' => $marketplaceSales->marketplace->getSlug(),
                'storeName' => $marketplaceSales->marketplace->getName(),
            ];
        });

        return $marketplaceSales->toArray();
    }

    private function getTotalSales(ProductSales $salesReport): array
    {
        $itemsSelled = $salesReport->getSaleItems()->get();
        $itemsSelled = collect($itemsSelled);

        $totalValue = $itemsSelled->sum(function (Item $saleItem) {
            return $saleItem->getTotalValue();
        });

        return [
            'quantity' => $itemsSelled->count(),
            'value' => NumberTransformer::toMoney($totalValue),
        ];
    }
}
