<?php

namespace Src\Sales\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'street',
        'number',
        'complement',
        'district',
        'city',
        'state',
        'zipcode',
    ];
}
