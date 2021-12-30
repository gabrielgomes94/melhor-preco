<?php

namespace Src\Costs\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseItems extends Model
{
    protected $fillable = [
        'freight_cost',
        'insurance_cost',
        'name',
        'quantity',
        'discount',
        'unit_cost',
        'unit_price',
        'taxes_cost',
    ];

//    protected $casts = [
//        'issued_at' => 'datetime',
//    ];

    protected $keyType = 'string';

    protected $primaryKey = 'uuid';

    protected $table = 'costs_purchase_items';
}
