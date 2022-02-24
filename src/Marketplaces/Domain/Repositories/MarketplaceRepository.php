<?php

namespace Src\Marketplaces\Domain\Repositories;

use Illuminate\Support\Collection;
use Src\Marketplaces\Application\Models\Marketplace;

interface MarketplaceRepository
{
    public function create(array $data): bool;

    public function exists(string $marketplaceUuid): bool;

    public function getByErpId(string $marketplaceErpId): ?Marketplace;

    public function getBySlug(string $marketplaceSlug): ?Marketplace;

    public function getByUuid(string $marketplaceUuid): ?Marketplace;

    public function list(): Collection;

    public function update(array $data, string $marketplaceId): bool;
}
