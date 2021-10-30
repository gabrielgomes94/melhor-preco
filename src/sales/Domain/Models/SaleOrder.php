<?php

namespace Src\Sales\Domain\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function customer()
    {
        return $this->hasOne(Customer::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function payment()
    {
        return $this->hasMany(PaymentInstallment::class);
    }

    public function shipment()
    {
        return $this->hasOne(Shipment::class);
    }
}
