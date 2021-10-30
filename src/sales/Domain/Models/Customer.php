<?php

namespace Src\Sales\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'fiscal_id',
        'state_registration',
        'document_number',
        'phones',
        'email',
        'phones',
    ];

    public function address()
    {
        return $this->hasOne(Address::class);
    }
}
