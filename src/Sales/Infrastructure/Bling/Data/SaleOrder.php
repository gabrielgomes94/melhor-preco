<?php

namespace Src\Sales\Infrastructure\Bling\Data;

use Illuminate\Support\Collection;
use Src\Sales\Domain\Models\ValueObjects\Customer\Customer;
use Src\Sales\Domain\Models\ValueObjects\Identifiers\Identifiers;
use Src\Sales\Domain\Models\ValueObjects\Invoice\Invoice;
use Src\Sales\Domain\Models\ValueObjects\Items\Items;
use Src\Sales\Domain\Models\ValueObjects\Payment\Payment;
use Src\Sales\Domain\Models\ValueObjects\Sale\SaleDates;
use Src\Sales\Domain\Models\ValueObjects\Sale\SaleValue;
use Src\Sales\Domain\Models\ValueObjects\Shipment\Shipment;
use Src\Sales\Domain\Models\ValueObjects\Status\Status;
use Src\Sales\Domain\Models\Contracts\SaleOrder as SaleOrderInterface;

class SaleOrder implements SaleOrderInterface
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

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function getIdentifiers(): Identifiers
    {
        return $this->identifiers;
    }

    public function getItems(): Items
    {
        return $this->items;
    }

    public function getInvoice(): ?Invoice
    {
        return $this->invoice;
    }

    public function getPayment(): ?Payment
    {
        return $this->payment;
    }

    public function getSaleDates(): SaleDates
    {
        return $this->saleDates;
    }

    public function getSaleValue(): SaleValue
    {
        return $this->saleValue;
    }

    public function getShipment(): ?Shipment
    {
        return $this->shipment;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }
}
