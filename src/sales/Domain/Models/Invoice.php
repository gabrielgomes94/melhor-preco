<?php

namespace Src\Sales\Domain\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function saleOrder()
    {
        return $this->belongsTo(SaleOrder::class);
    }
}
