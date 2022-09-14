<?php

namespace Src\Sales\Infrastructure\Laravel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @deprecated
 */
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

    protected $table = 'addresses';

    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }
}
