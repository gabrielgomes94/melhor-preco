<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Eloquent;

use Illuminate\Support\Collection;
use Src\Marketplaces\Application\Models\Marketplace;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository as MarketplaceRepositoryInterface;

class MarketplaceRepository implements MarketplaceRepositoryInterface
{
    public function getByErpId(string $marketplaceErpId): ?Marketplace
    {
        return Marketplace::where('erp_id', $marketplaceErpId)->first();
    }

    public function getBySlug(string $marketplaceSlug): ?Marketplace
    {
        return Marketplace::where('slug', $marketplaceSlug)->first();
    }

    public function list(): Collection
    {
        return Marketplace::all();
    }
}
