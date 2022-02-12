<?php

namespace Src\Sales\Application\Presenters;

use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Products\Domain\Models\Product\Product;
use Src\Sales\Domain\Models\SaleOrder;

class ListSalesPresenter
{
    private MarketplaceRepository $marketplaceRepository;

    public function __construct(MarketplaceRepository $marketplaceRepository)
    {
        $this->marketplaceRepository = $marketplaceRepository;
    }

    public function listSaleOrder(array $saleOrders): array
    {
        foreach ($saleOrders as $saleOrder) {
            $identifiers = $saleOrder->getIdentifiers();
            $saleValue = $saleOrder->getSaleValue();

            if (!$identifiers->storeId()) {
                continue;
            }

            $presented[] = [
                'saleOrderCode' => $identifiers->id(),
                'purchaseSaleOrderId' => $identifiers->purchaseSaleOrderId(),
                'storeSaleOrderId' => $identifiers->storeSaleOrderId(),
                'selledAt' => $this->presentSelledAt($saleOrder),
                'store' => $this->presentStore($identifiers),
                'value' => $saleValue->totalValue(),
                'products' => $this->presentProducts($saleOrder),
                'productsValue' => $saleValue->totalProducts(),
                'profit' => $saleOrder->getProfit() ?? '',
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
                $products[] = "{$product->getSku()} - {$product->getDetails()->getName()}";
            }
        }

        return $products ?? [];
    }

    private function presentSelledAt(SaleOrder $saleOrder): string
    {
        return $saleOrder->getSaleDates()->selledAt()->format('d-m-Y');
    }

    private function presentStore($identifiers): string
    {
        $marketplace = $this->marketplaceRepository->getByErpId($identifiers->storeId());

        if (!$marketplace) {
            return '';
        }

        return $marketplace->getName();
    }
}
