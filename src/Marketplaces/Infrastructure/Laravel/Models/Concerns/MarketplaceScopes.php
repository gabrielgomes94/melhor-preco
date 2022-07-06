<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait MarketplaceScopes
{
    public function scopeWithErpId(Builder $query, string $erpId): Builder
    {
        return $query->where('erp_id', $erpId);
    }

    public function scopeWithUser(Builder $query, string $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    public function scopeWithSlug(Builder $query, string $slug): Builder
    {
        return $query->where('slug', $slug);
    }
}
