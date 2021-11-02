<?php

namespace Src\Sales\Domain\Factories;

use Src\Sales\Domain\Models\Data\SaleOrder as SaleOrderData;
use Src\Sales\Domain\Models\SaleOrder as SaleOrderModel;

class SaleOrder
{
    public static function make(SaleOrderData $saleOrder)
    {
        $identifiers = $saleOrder->identifiers();
        $saleDates = $saleOrder->saleDates();
        $saleValue = $saleOrder->saleValue();

        return new SaleOrderModel([
            'sale_order_id' => $identifiers->id(),
            'purchase_order_id' => $identifiers->purchaseSaleOrderId(),
            'integration' => $identifiers->integration(),
            'store_id' => $identifiers->storeId(),
            'store_sale_order_id' => $identifiers->storeSaleOrderId(),
            'selled_at' => $saleDates->selledAt(),
            'dispatched_at' => $saleDates->dispatchedAt(),
            'expected_arrival_at' => $saleDates->expectedArrivalAt(),
            'discount' => $saleValue->discount(),
            'freight' => $saleValue->freight(),
            'status' => (string) $saleOrder->status(),
            'total_products' => $saleValue->totalProducts(),
            'total_value' => $saleValue->totalValue(),
        ]);
    }
}
