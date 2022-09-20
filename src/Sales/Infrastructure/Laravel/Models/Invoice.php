<?php

namespace Src\Sales\Infrastructure\Laravel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Src\Sales\Infrastructure\Laravel\Models\SaleOrder;

class Invoice extends Model
{
    protected $casts = [
        'issued_at' => 'datetime',
    ];

    protected $fillable = [
        'series',
        'number',
        'issued_at',
        'status',
        'value',
        'access_key',
        'sale_order_id',
    ];

    protected $table = 'sales_invoices';

    public function saleOrder(): BelongsTo
    {
        return $this->belongsTo(SaleOrder::class, 'sale_order_uuid', 'uuid');
    }
}
