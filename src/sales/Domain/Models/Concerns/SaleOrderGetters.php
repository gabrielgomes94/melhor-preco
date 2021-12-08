<?php

namespace Src\Sales\Domain\Models\Concerns;

use Illuminate\Database\Eloquent\Collection;
use Src\Products\Domain\Models\Store\Factory;
use Src\Sales\Domain\Factories\Customer as CustomerFactory;
use Src\Sales\Domain\Factories\Invoice;
use Src\Sales\Domain\Factories\Item;
use Src\Sales\Domain\Factories\PaymentInstallment;
use Src\Sales\Domain\Factories\Shipment as ShipmentFactory;
use Src\Sales\Domain\Models\ValueObjects\Customer\Customer as CustomerData;
use Src\Sales\Domain\Models\ValueObjects\Identifiers\Identifiers;
use Src\Sales\Domain\Models\ValueObjects\Invoice\Invoice as InvoiceObject;
use Src\Sales\Domain\Models\ValueObjects\Items\Items;
use Src\Sales\Domain\Models\ValueObjects\Payment\Payment;
use Src\Sales\Domain\Models\ValueObjects\Sale\SaleDates;
use Src\Sales\Domain\Models\ValueObjects\Sale\SaleValue;
use Src\Sales\Domain\Models\ValueObjects\Shipment\Shipment as ShipmentData;
use Src\Sales\Domain\Models\ValueObjects\Status\Status;

trait SaleOrderGetters
{
    public function getCustomer(): CustomerData
    {
        return CustomerFactory::make($this->customer);
    }

    public function getIdentifiers(): Identifiers
    {
        return new Identifiers(
            id: $this->sale_order_id,
            purchaseOrderId: $this->purchase_order_id,
            integration: $this->integration,
            storeId: $this->store_id,
            storeSaleOrderId: $this->store_sale_order_id);
    }

    public function getItems(): Items
    {
        foreach ($this->items as $item) {
            $items[] = Item::make($item);
        }

        return new Items($items ?? []);
    }

    public function getInvoice(): InvoiceObject
    {
        return Invoice::make($this->invoice);
    }

    public function getPayment(): Payment
    {
        foreach ($model->payments ?? [] as $payment) {
            $instalments[] = PaymentInstallment::make($payment);
        }

        return new Payment($instalments ?? []);
    }

    public function getProfit(): ?float
    {
        return $this->total_profit;
    }

    public function getSaleValue(): SaleValue
    {
        return new SaleValue(
            discount: $this->discount,
            freight: $this->freight,
            totalProducts: $this->total_products,
            totalValue: $this->total_value
        );
    }

    public function getSaleDates(): SaleDates
    {
        return new SaleDates(
            selledAt: $this->selled_at,
            dispatchedAt: $this->dispatched_at,
            expectedArrivalAt: $this->expected_arrival_at
        );
    }

    public function getShipment(): ShipmentData
    {
        return ShipmentFactory::make($this->shipment);
    }

    public function getStore()
    {
        return Factory::makeFromErpCode($this->store_id ?? '');
    }

    public function getStatus(): Status
    {
        return new Status($this->status);
    }
}
