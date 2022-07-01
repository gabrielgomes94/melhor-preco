<?php

namespace Src\Marketplaces\Domain\Repositories;

use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Marketplaces\Domain\DataTransfer\MarketplaceSettings;

interface MarketplaceRepository
{
    public function create(MarketplaceSettings $data): Marketplace;

    public function getByErpId(string $marketplaceErpId, string $userId): ?Marketplace;

    public function getBySlug(string $marketplaceSlug, string $userId): ?Marketplace;

//    public function getByUuid(string $marketplaceUuid): ?Marketplace;

    public function list(string $userId): array;

    public function update(Marketplace $marketplace, MarketplaceSettings $data): bool;
}
