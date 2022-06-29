<?php

namespace Src\Products\Infrastructure\Laravel\Services;

use Src\Prices\Infrastructure\Laravel\Services\Prices\SynchronizePrices;
use Src\Products\Domain\UseCases\SyncProducts as SyncProductsInterface;
use Src\Products\Infrastructure\Laravel\Services\SynchronizeProducts as SynchronizeProductsService;
use Src\Users\Domain\Entities\User;

class SynchronizeData implements SyncProductsInterface
{
    public function __construct(
        private SynchronizePrices $syncPricesService,
        private UpdateProductCosts $updateCostsService,
        private SynchronizeProductsService $syncProductsService
    ) {
    }

    public function sync(User $user): void
    {
        $this->syncProductsService->sync($user);
        $this->updateCostsService->sync($user);
        $this->syncPricesService->syncAll($user);
    }
}
