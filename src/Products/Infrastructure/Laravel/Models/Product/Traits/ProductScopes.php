<?php

namespace Src\Products\Infrastructure\Laravel\Models\Product\Traits;

use Illuminate\Database\Eloquent\Builder;

trait ProductScopes
{
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeWithParentSku($query, ?string $parentSku = '')
    {
        return $query->where('parent_sku', $parentSku);
    }

    public function scopeWithSku($query, string $sku)
    {
        return $query->where('sku', $sku)
            ->orWhere(function ($query) use ($sku) {
                $query->where('parent_sku', $sku);
            })
            ->orWhere(function ($query) use ($sku) {
                $sku = "%{$sku}%";

                $query->where('composition_products', 'like', $sku);
            });
    }

    public function scopeInCategory($query, string $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeFromUser($query, string $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeOrderBySku($query)
    {
        return $query->orderByRaw('CAST(sku AS INTEGER) DESC');
    }

    public function scopeIsOnStore($query, string $marketplace_uuid)
    {
        return $query->whereHas('prices', function (Builder $query) use ($marketplace_uuid) {
            $query->where('marketplace_uuid', '=', $marketplace_uuid);
        });
    }

    public function scopeIsNotVariation($query)
    {
        return $query->where('parent_sku', null);
    }
}
