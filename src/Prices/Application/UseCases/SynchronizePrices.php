<?php

namespace Src\Prices\Application\UseCases;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Src\Calculator\Application\Services\CalculateProfit;
use Src\Integrations\Bling\Products\Requests\Config;
use Src\Marketplaces\Domain\Models\Contracts\Marketplace;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Marketplaces\Domain\UseCases\Contracts\GetCommission;
use Src\Prices\Application\Jobs\SyncPrices;
use Src\Prices\Domain\Events\PriceSynchronized;
use Src\Prices\Domain\Events\PriceWasNotSynchronized;
use Src\Prices\Domain\Models\Price;
use Src\Prices\Domain\UseCases\Contracts\SynchronizePrices as SynchronizePricesInterface;
use Src\Products\Application\Exceptions\ProductNotFoundException;
use Src\Products\Domain\Models\Product\Product;
use Src\Products\Infrastructure\Bling\ProductRepository as BlingRepository;
use Src\Products\Infrastructure\Bling\Responses\Prices\PricesCollectionResponse;
use TypeError;

use function event;

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
