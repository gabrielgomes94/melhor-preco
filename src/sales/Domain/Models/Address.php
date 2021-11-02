<?php

namespace Src\Sales\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Src\Sales\Domain\Factories\Address as AddressFactory;
use Src\Sales\Domain\Models\Data\Address\Address as AddressData;

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

    public function data(): AddressData
    {
        return AddressFactory::make($this);
    }
}
