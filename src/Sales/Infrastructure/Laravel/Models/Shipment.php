<?php

namespace Src\Sales\Infrastructure\Laravel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Src\Sales\Infrastructure\Laravel\Models\Address;

class Shipment extends Model
{
    protected $fillable = [
        'name',
    ];

    protected $table = 'sales_shipments';

    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable');
    }
}
