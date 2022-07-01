<?php

namespace Src\Marketplaces\Domain\Repositories;

use Illuminate\Support\Collection;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Marketplaces\Domain\DataTransfer\MarketplaceSettings;

interface MarketplaceRepository
{
    public function create(MarketplaceSettings $data): Marketplace;

    public function exists(string $marketplaceUuid): bool;

    public function getByErpId(string $marketplaceErpId): ?Marketplace;

    public function getBySlug(string $marketplaceSlug): ?Marketplace;

    public function getByUuid(string $marketplaceUuid): ?Marketplace;

    public function list(): Collection;

    public function update(Marketplace $marketplace, MarketplaceSettings $data): bool;
}
