<?php

namespace Src\Sales\Domain\Models\Contracts;

use Src\Sales\Domain\Models\ValueObjects\SaleIdentifiers;
use Src\Sales\Domain\Models\ValueObjects\SaleDates;
use Src\Sales\Domain\Models\ValueObjects\SaleValue;
use Src\Sales\Domain\Models\ValueObjects\Status;
use Src\Sales\Infrastructure\Laravel\Models\Customer;
use Src\Sales\Infrastructure\Laravel\Models\Invoice;
use Src\Sales\Infrastructure\Laravel\Models\Shipment;

interface SaleOrder
{
    public function getCustomer(): Customer;

    public function getIdentifiers(): SaleIdentifiers;

    public function getItems(): array;

    public function getInvoice(): ?Invoice;

    public function getSaleDates(): SaleDates;

    public function getSaleValue(): SaleValue;

    public function getShipment(): ?Shipment;

    public function getStatus(): Status;

    public function setStatus(string $status): void;
}
