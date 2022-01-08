<?php

namespace Src\Costs\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Src\Products\Domain\Models\Product\Product;

class PurchaseItem extends Model
{
    protected $fillable = [
        'freight_cost',
        'insurance_cost',
        'name',
        'quantity',
        'discount',
        'unit_cost',
        'unit_price',
        'taxes',
        'product_sku',
        'ean',
    ];

    protected $casts = [
        'taxes' => 'json',
    ];

    protected $keyType = 'string';

    protected $primaryKey = 'uuid';

    protected $table = 'costs_purchase_items';

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(PurchaseInvoice::class, 'purchase_invoice_uuid', 'uuid');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'ean', 'ean');
    }

    public function getFreightCosts(): float
    {
        return $this->freight_cost ?? 0.0;
    }

    public function getICMSPercentage(): float
    {
        return $this->taxes['icms'][' percentage'] ?? 0.0;
    }

    public function getInsuranceCosts(): float
    {
        return $this->insurance_cost ?? 0.0;
    }

    public function getIpiValue(): float
    {
        return ($this->taxes['ipi']['value'] / $this->quantity) ?: 0.0;
    }

    public function getIssuedAt(): Carbon
    {
        return $this->invoice->getIssuedAt();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getProductSku(): ?string
    {
        return $this->sku ?? null;
    }

    public function getPurchaseItemUuid(): string
    {
        return $this->uuid;
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }

    public function getTotalTaxesCosts(): float
    {
        $totalTaxes = $this->taxes['totalTaxes'] ?: $this->getIpiValue();

        return  $totalTaxes / $this->quantity ?: 0.0;
    }

    public function getTotalValue(): float
    {
        return $this->unit_cost * $this->quantity;
    }

    public function getUnitPrice(): float
    {
        return $this->unit_price;
    }

    public function getUnitCost(): float
    {
        return $this->unit_cost;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }
}
