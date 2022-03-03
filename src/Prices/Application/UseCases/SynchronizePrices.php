<?php

namespace Src\Prices\Application\UseCases;

use Src\Marketplaces\Domain\Models\Contracts\Marketplace;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Prices\Application\Jobs\SyncPrices;
use Src\Prices\Domain\UseCases\Contracts\SynchronizePrices as SynchronizePricesInterface;


class SynchronizePrices implements SynchronizePricesInterface
{
    public function __construct(
        private MarketplaceRepository $marketplaceRepository
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
