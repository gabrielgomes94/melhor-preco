<?php

namespace Src\Prices\Domain\UseCases\Price;

interface SynchronizePrices
{
    public function syncAll(): void;

    public function syncMarketplace(string $marketplaceSlug): void;
}
