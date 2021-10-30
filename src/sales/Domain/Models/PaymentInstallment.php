<?php

namespace Src\Sales\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentInstallment extends Model
{
    protected $fillable = [
        'id',
        'value',
        'expires_at',
        'observation',
        'destination',
    ];

}
