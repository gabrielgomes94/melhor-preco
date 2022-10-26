<?php

namespace Src\Sales\Domain\Models\Contracts;

use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Sales\Domain\Models\ValueObjects\SaleIdentifiers;
use Src\Sales\Domain\Models\ValueObjects\SaleDates;
use Src\Sales\Domain\Models\ValueObjects\SaleValue;
use Src\Sales\Application\Models\Invoice;
use Src\Sales\Application\Models\Shipment;

interface SaleOrder
{
    public function getIdentifiers(): SaleIdentifiers;

    public function getItems(): array;

    public function getInvoice(): ?Invoice;

    public function getMarketplace(): ?Marketplace;

    public function getSaleDates(): SaleDates;

    public function getSaleValue(): SaleValue;

    public function getShipment(): ?Shipment;

    public function getStatus(): string;

    public function getUuid(): string;

    public function setStatus(string $status): void;
}
