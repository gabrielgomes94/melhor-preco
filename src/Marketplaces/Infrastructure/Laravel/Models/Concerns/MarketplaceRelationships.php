<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Src\Prices\Infrastructure\Laravel\Models\Price;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;
use Src\Users\Infrastructure\Laravel\Models\User;

trait MarketplaceRelationships
{
    public function products(): HasManyThrough
    {
        return $this->hasManyThrough(
            Product::class,
            Price::class,
            'marketplace_erp_id',
            'uuid',
            'erp_id',
            'product_uuid'
        );
    }

    public function prices(): HasMany
    {
        return $this->hasMany(Price::class, 'marketplace_erp_id', 'erp_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
