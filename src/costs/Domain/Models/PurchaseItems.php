<?php

namespace Src\Costs\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Src\Products\Domain\Models\Product\Product;

// @todo: adicionar métodos getters e encapsular lógica de cálculo de custos nesse objeto
class PurchaseItems extends Model
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

    public function getName(): string
    {
        return $this->name;
    }

    public function getUnitPrice(): float
    {
        return $this->unit_price;
    }

    public function getFreightCosts(): float
    {
        return $this->freight_cost ?? 0.0;
    }

    public function getTotalTaxesCosts(): float
    {
        return $this->taxes['totalTaxes'] ?? 0.0;
    }

    public function getInsuranceCosts(): float
    {
        return $this->insurance_cost ?? 0.0;
    }

    public function getUnitCost(): float
    {
        return $this->unit_cost;
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }

    public function getTotalValue(): float
    {
        return $this->unit_cost * $this->quantity;
    }

    public function getPurchaseItemUuid(): string
    {
        return $this->uuid;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getProductSku(): ?string
    {
        return $this->sku ?? null;
    }
}
