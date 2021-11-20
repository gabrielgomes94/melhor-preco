<?php

namespace Src\Sales\Application\Presenters;

use Src\Prices\Calculator\Domain\Services\CalculatePrice;
use Src\Products\Domain\Product\Models\Product;
use Src\Products\Domain\Store\Factory;
use Src\Sales\Domain\Models\SaleOrder;

class ListSalesPresenter
{
    private CalculatePrice $calculatePrice;

    public function __construct(CalculatePrice $calculatePrice)
    {
        $this->calculatePrice = $calculatePrice;
    }

    public function listSaleOrder(array $saleOrders): array
    {
        foreach ($saleOrders as $saleOrder)
        {
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

//        dd($presented);

        return $presented ?? [];
    }

    private function presentProducts(SaleOrder $saleOrder): array
    {
//        dd($saleOrder->getItems());
        foreach ($saleOrder->getItems() as $item) {
            if (!$product = Product::find($item->getSku())) {
//                dd($product);
                continue;
            }

//            dd('oi', $product);

            $product = $product->data();
            $products[] = "{$product->getSku()} - {$product->getDetails()->getName()}";
//            dd($products);
        }

        return $products ?? [];
    }

    private function presentSelledAt(SaleOrder $saleOrder): string
    {
        return $saleOrder->getSaleDates()->selledAt()->format('d-m-Y');
    }

    private function presentStore($identifiers): string
    {
        return Factory::makeFromErpCode($identifiers->storeId())->getName();
    }
}
