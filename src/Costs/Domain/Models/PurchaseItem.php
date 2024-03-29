<?php

namespace Src\Costs\Domain\Models;

use Illuminate\Support\Carbon;

interface PurchaseItem
{
    public function getDiscount(): float;

    public function getEan(): string;

    public function getFreightCosts(): float;

    public function getICMSPercentage(): float;

    public function getInsuranceCosts(): float;

    public function getIpiValue(): float;

    public function getIssuedAt(): Carbon;

    public function getName(): string;

    public function getProductSku(): ?string;

    public function getPurchaseItemUuid(): string;

    public function getQuantity(): float;

    public function getSupplierName(): string;

    public function getSupplierFiscalId(): string;

    public function getTotalTaxesCosts(): float;

    public function getTotalValue(): float;

    public function getUnitPrice(): float;

    public function getUnitCost(): float;

    public function getUuid(): string;
}
