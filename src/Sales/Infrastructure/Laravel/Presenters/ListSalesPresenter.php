<?php

namespace Src\Sales\Infrastructure\Laravel\Presenters;

use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Math\MathPresenter;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;
use Src\Sales\Domain\Models\SaleOrder;

class ListSalesPresenter
{
    private MarketplaceRepository $marketplaceRepository;

    public function __construct(MarketplaceRepository $marketplaceRepository)
    {
        $this->marketplaceRepository = $marketplaceRepository;
    }

    public function listSaleOrder(array $saleOrders, string $userId): array
    {
        foreach ($saleOrders as $saleOrder) {
            $identifiers = $saleOrder->getIdentifiers();
            $saleValue = $saleOrder->getSaleValue();

            if (!$identifiers->storeId()) {
                continue;
            }

            $products = $this->presentProducts($saleOrder);

            $presented[] = [
                'saleOrderCode' => $identifiers->id(),
                'purchaseSaleOrderId' => $identifiers->purchaseSaleOrderId(),
                'storeSaleOrderId' => $identifiers->storeSaleOrderId(),
                'selledAt' => $this->presentSelledAt($saleOrder),
                'store' => $this->presentStore($identifiers, $userId),
                'value' => MathPresenter::money($saleValue->totalValue()),
                'products' => $products,
                'productsInTooltip' => $this->presentProductsInTooltip($products),
                'productsValue' => $saleValue->totalProducts(),
                'profit' => $this->getProfit($saleOrder),
                'status' => (string) $saleOrder->getStatus(),
            ];
        }

        return $presented ?? [];
    }

    private function presentProducts(SaleOrder $saleOrder): array
    {
        foreach ($saleOrder->getItems()->get() as $item) {
            if (!$product = Product::where('sku', $item->sku())->first()) {
                continue;
            }

            for ($i = 0; $i < $item->getQuantity(); $i++) {
                $products[] = [
                    'formattedName' => "{$product->getSku()} - {$product->getDetails()->getName()}",
                    'sku' => $product->getSku(),
                ];
            }
        }

        return $products ?? [];
    }

    private function presentSelledAt(SaleOrder $saleOrder): string
    {
        return $saleOrder->getSaleDates()->selledAt()->format('d/m/Y');
    }

    private function presentStore($identifiers, string $userId): string
    {
        $marketplace = $this->marketplaceRepository->getByErpId($identifiers->storeId(), $userId);

        if (!$marketplace) {
            return '';
        }

        return $marketplace->getName();
    }

    private function getProfit(SaleOrder $saleOrder): string
    {
        $profit = $saleOrder->getProfit();

        return $profit
            ? MathPresenter::money($profit)
            : '';
    }

    private function presentProductsInTooltip(array $products): string
    {
        return implode(
            ';',
            array_column($products, 'formattedName')
        );
    }
}
