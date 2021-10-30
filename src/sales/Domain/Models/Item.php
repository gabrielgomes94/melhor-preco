<?php

namespace Src\Sales\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'sku',
        'name',
        'quantity',
        'unit_value',
        'discount',
    ];

}
