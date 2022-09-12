<?php

namespace Src\Prices\Domain\Services;

use Src\Marketplaces\Domain\Models\Marketplace;

interface SynchronizeFromMarketplace
{
    public const ACTIVE = 'active';
    public const INACTIVE = 'inactive';

    public function sync(
        Marketplace $marketplace,
        int $page = 1,
        string $status = self::ACTIVE
    ): bool;
}
