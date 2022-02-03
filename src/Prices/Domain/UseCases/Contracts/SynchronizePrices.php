<?php

namespace Src\Prices\Domain\UseCases\Contracts;

interface SynchronizePrices
{
    public function syncAll(): void;

    public function syncMarketplace(string $marketplaceSlug): void;
}
