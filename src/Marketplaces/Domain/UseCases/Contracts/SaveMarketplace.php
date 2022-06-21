<?php

namespace Src\Marketplaces\Domain\UseCases\Contracts;

use Src\Marketplaces\Domain\DataTransfer\MarketplaceSettings;

interface SaveMarketplace
{
    public function save(MarketplaceSettings $data, ?string $marketplaceId = null): bool;
}
