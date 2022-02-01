<?php

namespace Src\Products\Application\UseCases;

use Src\Prices\Application\UseCases\SynchronizePrices;
use Src\Products\Application\Services\SynchronizeProductCosts;
use Src\Products\Application\Services\SynchronizeProducts as SynchronizeProductsService;
use Src\Products\Domain\UseCases\Contracts\SyncProducts as SyncProductsInterface;

class SynchronizeProducts implements SyncProductsInterface
{
    private SynchronizePrices $syncPricesService;
    private SynchronizeProductCosts $syncCostsService;
    private SynchronizeProductsService $syncProductsService;

    public function __construct(
        SynchronizePrices $syncPricesService,
        SynchronizeProductCosts $syncCostsService,
        SynchronizeProductsService $syncProductsService
    ) {
        $this->syncPricesService = $syncPricesService;
        $this->syncCostsService = $syncCostsService;
        $this->syncProductsService = $syncProductsService;
    }

    public function sync(): void
    {
        $this->syncProductsService->sync();
        $this->syncCostsService->sync();
        $this->syncPricesService->sync();
    }
}
