<?php

namespace Src\Sales\Domain\Models\Data;

use Src\Sales\Domain\Models\Data\Customer\Customer;
use Src\Sales\Domain\Models\Data\Identifiers\Identifiers;
use Src\Sales\Domain\Models\Data\Invoice\Invoice;
use Src\Sales\Domain\Models\Data\Items\Items;
use Src\Sales\Domain\Models\Data\Payment\Payment;
use Src\Sales\Domain\Models\Data\Sale\SaleDates;
use Src\Sales\Domain\Models\Data\Sale\SaleValue;
use Src\Sales\Domain\Models\Data\Shipment\Shipment;
use Src\Sales\Domain\Models\Data\Status\Status;

class SaleOrder
{
    private Customer $customer;
    private Identifiers $identifiers;
    private Items $items;
    private SaleDates $saleDates;
    private SaleValue $saleValue;
    private Status $status;

    private ?Invoice $invoice;
    private ?Payment $payment;
    private ?Shipment $shipment;

    public function __construct(
        Identifiers $identifiers,
        SaleValue $saleValue,
        SaleDates $saleDates,
        Status $status,
        Items $items,
        Customer $customer,
        ?Invoice $invoice,
        ?Payment $payment,
        ?Shipment $shipment
    ) {
        $this->identifiers = $identifiers;
        $this->saleValue = $saleValue;
        $this->saleDates = $saleDates;
        $this->status = $status;
        $this->items = $items;
        $this->customer = $customer;
        $this->invoice = $invoice;
        $this->payment = $payment;
        $this->shipment = $shipment;
    }

    public function toArray(): array
    {
        return [
            'identifiers' => $this->identifiers->toArray(),
            'saleValue' => $this->saleValue->toArray(),
            'saleDates' => $this->saleDates->toArray(),
            'status' => (string) $this->status,
            'customer' => $this->customer->toArray(),
            'invoice' => $this->invoice?->toArray() ?? [],
            'items' => $this->items->toArray(),
            'payment' => $this->payment?->toArray() ?? [],
            'shipment' => $this->shipment?->toArray() ?? [],
        ];
    }

    public function customer(): Customer
    {
        return $this->customer;
    }

    public function identifiers(): Identifiers
    {
        return $this->identifiers;
    }

    public function invoice(): ?Invoice
    {
        return $this->invoice;
    }

    public function items(): Items
    {
        return $this->items;
    }

    public function payment(): ?Payment
    {
        return $this->payment;
    }

    public function saleDates(): SaleDates
    {
        return $this->saleDates;
    }

    public function saleValue(): SaleValue
    {
        return $this->saleValue;
    }

    public function shipment(): ?Shipment
    {
        return $this->shipment;
    }

    public function status(): Status
    {
        return $this->status;
    }
}
