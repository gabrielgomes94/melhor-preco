<?php

namespace Src\Marketplaces\Domain\Repositories;

use Illuminate\Support\Collection;
use Src\Marketplaces\Domain\Models\Marketplace;

interface MarketplaceRepository
{
    public function list(): Collection;

    public function getBySlug(string $marketplaceSlug): ?Marketplace;
}
