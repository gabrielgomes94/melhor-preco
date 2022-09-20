<?php

namespace Src\Sales\Infrastructure\Laravel\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Sales\Infrastructure\Laravel\Models\Customer;
use Src\Sales\Infrastructure\Laravel\Models\Invoice;
use Src\Sales\Infrastructure\Laravel\Models\Item;
use Src\Sales\Infrastructure\Laravel\Models\Shipment;
use Src\Users\Infrastructure\Laravel\Models\User;

trait SaleOrderRelationships
{
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class, 'sale_order_uuid', 'uuid');
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class, 'sale_order_uuid', 'uuid');
    }

    public function marketplace(): BelongsTo
    {
        return $this->belongsTo(Marketplace::class, 'marketplace_uuid', 'uuid');
    }

    public function shipment(): HasOne
    {
        return $this->hasOne(Shipment::class, 'sale_order_uuid', 'uuid');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
