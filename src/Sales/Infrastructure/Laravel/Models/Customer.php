<?php

namespace Src\Sales\Infrastructure\Laravel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @deprecated
 */
class Customer extends Model
{
    protected $fillable = [
        'name',
        'fiscal_id',
        'document_number',
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

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function saleOrders(): HasMany
    {
        return $this->hasMany(SaleOrder::class);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getFiscalId(): string
    {
        return $this->fiscal_id;
    }
}
