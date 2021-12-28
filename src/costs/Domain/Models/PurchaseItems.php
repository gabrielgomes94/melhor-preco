<?php

namespace Src\costs\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseItems extends Model
{
    protected $fillable = [
        'freight_cost',
        'insurance_cost',
        'name',
        'quantity',
        'unit_cost',
        'unit_price',
        'taxes_cost',
//        'uuid',
    ];

//    protected $casts = [
//        'issued_at' => 'datetime',
//    ];

    protected $keyType = 'string';

    protected $primaryKey = 'uuid';

    protected $table = 'costs_purchase_items';
}
