<?php

namespace Src\Prices\Infrastructure\Laravel\Services\Prices;

use Src\Integrations\Bling\Products\Requests\Config;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Prices\Domain\Services\Price\SynchronizePrices as SynchronizePricesInterface;
use Src\Prices\Infrastructure\Laravel\Jobs\SyncPrices;


class SynchronizePrices implements SynchronizePricesInterface
{
    public function __construct(
        private readonly MarketplaceRepository $marketplaceRepository
    ) {}

    public function syncAll(string $userId): void
    {
        $marketplaces = $this->marketplaceRepository->list($userId);

        foreach ($marketplaces as $marketplace) {
            $this->sync($marketplace);
        }
    }

    public function syncMarketplace(string $marketplaceSlug, string $userId): void
    {
        $marketplace = $this->marketplaceRepository->getBySlug($marketplaceSlug, $userId);

        $this->sync($marketplace);
    }

    private function sync(Marketplace $marketplace): void
    {
        $page = 1;
        SyncPrices::dispatch($marketplace, $page, Config::ACTIVE);
        SyncPrices::dispatch($marketplace, $page, Config::INACTIVE);
    }
}
