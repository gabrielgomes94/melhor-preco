<?php

namespace Src\Sales\Domain\Models\Contracts;

use Illuminate\Support\Collection;
use Src\Sales\Domain\Models\ValueObjects\Customer\Customer;
use Src\Sales\Domain\Models\ValueObjects\Identifiers\Identifiers;
use Src\Sales\Domain\Models\ValueObjects\Invoice\Invoice as InvoiceData;
use Src\Sales\Domain\Models\ValueObjects\Items\Items;
use Src\Sales\Domain\Models\ValueObjects\Payment\Payment;
use Src\Sales\Domain\Models\ValueObjects\Sale\SaleDates;
use Src\Sales\Domain\Models\ValueObjects\Sale\SaleValue;
use Src\Sales\Domain\Models\ValueObjects\Shipment\Shipment as ShipmentData;
use Src\Sales\Domain\Models\ValueObjects\Status\Status;
use Src\Sales\Infrastructure\Laravel\Models\Item;

interface SaleOrder
{
    public function getCustomer(): Customer;

    public function getIdentifiers(): Identifiers;

    public function getItems(): Items;

    public function getInvoice(): ?InvoiceData;

    public function getSaleDates(): SaleDates;

    public function getSaleValue(): SaleValue;

    public function getShipment(): ?ShipmentData;

    public function getStatus(): Status;
}
