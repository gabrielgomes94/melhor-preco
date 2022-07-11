<?php

namespace Src\Sales\Domain\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Sales\Domain\Models\Customer;
use Src\Sales\Domain\Models\Invoice;
use Src\Sales\Domain\Models\Item;
use Src\Sales\Domain\Models\Shipment;

trait SaleOrderRelationships
{
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    public function marketplace(): BelongsTo
    {
        return $this->belongsTo(Marketplace::class, 'store_id', 'erp_id');
    }

    public function shipment(): HasOne
    {
        return $this->hasOne(Shipment::class);
    }
}
