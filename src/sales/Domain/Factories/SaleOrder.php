<?php

namespace Src\Sales\Domain\Factories;

use Src\Sales\Domain\Models\Contracts\SaleOrder as SaleOrderInterface;
use Src\Sales\Domain\Models\ValueObjects\Identifiers\Identifiers;
use Src\Sales\Domain\Models\ValueObjects\Items\Items;
use Src\Sales\Domain\Models\ValueObjects\Payment\Payment;
use Src\Sales\Domain\Models\ValueObjects\Sale\SaleDates;
use Src\Sales\Domain\Models\ValueObjects\Sale\SaleValue;
use Src\Sales\Infrastructure\Bling\Data\SaleOrder as SaleOrderData;
use Src\Sales\Domain\Models\ValueObjects\Status\Status;
use Src\Sales\Domain\Models\SaleOrder as SaleOrderModel;

class SaleOrder
{
    public static function make(SaleOrderModel $model)
    {
        foreach ($model->items as $item) {
            $items[] = Item::make($item);
        }

        foreach ($model->payments ?? [] as $payment)
        {
            $instalments[] = PaymentInstallment::make($payment);
        }

        return new SaleOrderData(
            identifiers: new Identifiers(
                id: $model->sale_order_id,
                purchaseOrderId: $model->purchase_order_id,
                integration: $model->integration,
                storeId: $model->store_id,
                storeSaleOrderId: $model->store_sale_order_id),
            saleValue: new SaleValue(
                discount: $model->discount,
                freight: $model->freight,
                totalProducts: $model->total_products,
                totalValue: $model->total_value
            ),
            saleDates: new SaleDates(
                selledAt: $model->selled_at,
                dispatchedAt: $model->dispatched_at,
                expectedArrivalAt: $model->expected_arrival_at
            ),
            status: new Status($model->status),
            items: new Items($items ?? []),
            customer: Customer::make($model->customer),
            invoice: Invoice::make($model->invoice),
            payment: new Payment($instalments ?? []),
            shipment: Shipment::make($model->shipment)
        );
    }


    public static function makeModel(SaleOrderInterface $saleOrder)
    {
        $identifiers = $saleOrder->getIdentifiers();
        $saleDates = $saleOrder->getSaleDates();
        $saleValue = $saleOrder->getSaleValue();

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
            'status' => (string) $saleOrder->getStatus(),
            'total_products' => $saleValue->totalProducts(),
            'total_value' => $saleValue->totalValue(),
        ]);
    }
}
