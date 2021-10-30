<?php

namespace Src\Sales\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $fillable = [
        'name',
    ];

    public function address()
    {
        return $this->hasOne(Address::class);
    }
}
