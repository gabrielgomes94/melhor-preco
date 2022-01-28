<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Eloquent;

use Illuminate\Support\Collection;
use Src\Marketplaces\Domain\Models\Marketplace;

class MarketplaceRepository
{
    public function list(): Collection
    {
        return Marketplace::all();
    }
}
