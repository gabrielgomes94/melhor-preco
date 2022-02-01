<?php

namespace Src\Marketplaces\Domain\Repositories;

use Illuminate\Support\Collection;
use Src\Marketplaces\Domain\Models\Marketplace;

interface MarketplaceRepository
{
    public function getByErpId(string $marketplaceErpId): ?Marketplace;

    public function getBySlug(string $marketplaceSlug): ?Marketplace;

    public function list(): Collection;
}
