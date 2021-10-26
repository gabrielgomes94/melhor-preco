<?php

namespace Src\Sales\Domain\Models;

use Src\Sales\Domain\Models\Data\Address\Address;
use Src\Sales\Domain\Models\Data\Identifiers;
use Src\Sales\Domain\Models\Data\Invoice\Invoice;
use Src\Sales\Domain\Models\Data\Items;
use Src\Sales\Domain\Models\Data\Payment\Payment;
use Src\Sales\Domain\Models\Data\SaleDates;
use Src\Sales\Domain\Models\Data\SaleValue;
use Src\Sales\Domain\Models\Data\Shipment\Shipment;
use Src\Sales\Domain\Models\Data\Status;
use Carbon\Carbon;
use Src\Sales\Domain\Models\Customer;

class SaleOrder
{
    private Customer $customer;
    private Identifiers $identifiers;
    private Invoice $invoice;
    private Items $items;
    private Payment $payment;
    private SaleDates $saleDates;
    private SaleValue $saleValue;
    private Shipment $shipment;
    private Status $status;

    public function __construct(
        Identifiers $identifiers,
        SaleValue $saleValue,
        SaleDates $saleDates,
        Status $status,
        Customer $customer,
        Invoice $invoice,
        Items $items,
        Payment $payment,
        Shipment $shipment
    ) {
        $this->identifiers = $identifiers;
        $this->saleValue = $saleValue;
        $this->saleDates = $saleDates;
        $this->status = $status;
        $this->customer = $customer;
        $this->invoice = $invoice;
        $this->items = $items;
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
            'invoice' => $this->invoice->toArray(),
            'items' => $this->items->toArray(),
            'payment' => $this->payment->toArray(),
            'shipment' => $this->shipment->toArray(),
        ];
    }

    public function identifiers(): Identifiers
    {
        return $this->identifiers;
    }

    public function saleDates(): SaleDates
    {
        return $this->saleDates;
    }

    public function saleValue(): SaleValue
    {
        return $this->saleValue;
    }

    public function items(): Items
    {
        return $this->items;
    }

    public function status(): Status
    {
        return $this->status;
    }
}
