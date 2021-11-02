<?php

namespace Src\Sales\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentInstallment extends Model
{
    protected $fillable = [
        'id',
        'value',
        'expires_at',
        'observation',
        'destination',
    ];

    protected $table = 'sales_payments';

    public function saleOrder(): BelongsTo
    {
        return $this->belongsTo(SaleOrder::class);
    }
}
