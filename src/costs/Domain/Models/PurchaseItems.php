<?php

namespace Src\costs\Domain\Models;

class PurchaseItems
{
    protected $fillable = [
        'unit_price',
        'quantity',
        'taxes_cost',
        'insurance_cost',
        'freight_cost',
        'unit_cost',
        'name'
    ];

}
