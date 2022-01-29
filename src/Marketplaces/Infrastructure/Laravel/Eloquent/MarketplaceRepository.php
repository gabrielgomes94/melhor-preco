<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Eloquent;

use Illuminate\Support\Collection;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository as MarketplaceRepositoryInterface;

class MarketplaceRepository implements MarketplaceRepositoryInterface
{
    public function list(): Collection
    {
        return Marketplace::all();
    }
}
