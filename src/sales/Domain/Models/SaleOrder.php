<?php

namespace Src\Sales\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SaleOrder extends Model
{
    protected $fillable = [
        'sale_order_id',
        'purchase_order_id',
        'integration',
        'store_id',
        'store_sale_order_id',
        'selled_at',
        'dispatched_at',
        'expected_arrival_at',
        'discount',
        'freight',
        'status',
        'total_products',
        'total_value',
    ];

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

    public function payment(): HasMany
    {
        return $this->hasMany(PaymentInstallment::class);
    }

    public function shipment(): HasOne
    {
        return $this->hasOne(Shipment::class);
    }
}
