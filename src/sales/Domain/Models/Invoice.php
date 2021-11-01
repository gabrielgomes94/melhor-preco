<?php

namespace Src\Sales\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    protected $fillable = [
        'series',
        'number',
        'issued_at',
        'status',
        'value',
        'access_key',
    ];

    protected $table = 'sales_invoice';

    public function saleOrder(): BelongsTo
    {
        return $this->belongsTo(SaleOrder::class);
    }
}
