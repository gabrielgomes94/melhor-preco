<?php

namespace Src\Prices\Domain\UseCases\Price;

interface SynchronizePrices
{
    public function syncAll(string $userId): void;

    public function syncMarketplace(string $marketplaceSlug, string $userId): void;
}
