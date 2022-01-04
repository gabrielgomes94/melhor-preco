<?php

namespace Src\Costs\Domain\Models;

use Illuminate\Database\Eloquent\Model;

// @todo: adicionar métodos getters e encapsular lógica de cálculo de custos nesse objeto
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
        'taxes'
    ];

    protected $casts = [
        'taxes' => 'json',
    ];

    protected $keyType = 'string';

    protected $primaryKey = 'uuid';

    protected $table = 'costs_purchase_items';
}
