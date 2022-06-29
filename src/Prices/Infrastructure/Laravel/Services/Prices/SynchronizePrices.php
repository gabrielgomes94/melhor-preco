<?php

namespace Src\Prices\Infrastructure\Laravel\Services\Prices;

use Src\Marketplaces\Domain\Models\Contracts\Marketplace;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Prices\Domain\UseCases\Price\SynchronizePrices as SynchronizePricesInterface;
use Src\Prices\Infrastructure\Laravel\Jobs\SyncPrices;


class SynchronizePrices implements SynchronizePricesInterface
{
    public function __construct(
        private readonly MarketplaceRepository $marketplaceRepository
    ) {}

    public function syncAll(): void
    {
        $marketplaces = $this->marketplaceRepository->list();

        foreach ($marketplaces as $marketplace) {
            $this->sync($marketplace);
        }
    }

    public function syncMarketplace(string $marketplaceSlug): void
    {
        $marketplace = $this->marketplaceRepository->getBySlug($marketplaceSlug);
        $this->sync($marketplace);
    }

    private function sync(Marketplace $marketplace): void
    {
        $page = 1;
        SyncPrices::dispatch($marketplace, $page);
    }
}
