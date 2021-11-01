<?php

namespace Src\Sales\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'fiscal_id',
        'state_registration',
        'document_number',
        'email',
        'phones',
    ];

    protected $casts = [
        'phones' => 'array',
    ];

    protected $table = 'customers';

    public function address(): MorphOne
    {
        return $this->morphOne(related: Address::class, name: 'addressable');
    }

    public function saleOrders(): HasMany
    {
        return $this->hasMany(SaleOrder::class);
    }
}
