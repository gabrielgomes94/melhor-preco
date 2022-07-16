<?php

namespace Src\Marketplaces\Domain\Repositories;

use Src\Marketplaces\Domain\DataTransfer\MarketplaceSettings;
use Src\Marketplaces\Domain\Models\Marketplace;

interface MarketplaceRepository
{
    public function create(MarketplaceSettings $data): Marketplace;

    public function first(string $userId): ?Marketplace;

    public function getByErpId(string $marketplaceErpId, string $userId): ?Marketplace;

    public function getBySlug(string $marketplaceSlug, string $userId): ?Marketplace;

    public function list(string $userId): array;

    public function update(Marketplace $marketplace, MarketplaceSettings $data): bool;
}
