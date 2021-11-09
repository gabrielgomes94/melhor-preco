<?php

namespace Src\Sales\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Src\Sales\Domain\Factories\SaleOrder as SaleOrderFactory;
use Src\Sales\Domain\Models\Data\SaleOrder as SaleOrderData;

class SaleOrder extends Model
{
    protected $casts = [
        'sale_order_id' => 'integer',
        'selled_at' => 'datetime',
        'dispatched_at' => 'datetime',
        'expected_arrival_at' => 'datetime',
    ];

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

    public function scopeValid($query)
    {
        return $query->where('status', '<>', 'Cancelado');
    }

    public function data(): SaleOrderData
    {
        return SaleOrderFactory::make($this);
    }

    public function isFromStore()
    {

    }
}
