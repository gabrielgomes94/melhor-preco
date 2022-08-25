<?php

namespace Src\Products\Infrastructure\Laravel\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Src\Prices\Infrastructure\Laravel\Services\Prices\SynchronizePrices;
use Src\Products\Infrastructure\Laravel\Services\SynchronizeProductCosts;
use Src\Products\Infrastructure\Laravel\Services\SynchronizeProducts as SynchronizeProductsService;
use Src\Users\Domain\Models\User;

class SyncProducts implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(private User $user)
    {}

    public function handle(
        SynchronizePrices $syncPricesService,
        SynchronizeProductCosts $syncCostsService,
        SynchronizeProductsService $syncProductsService
    ): void
    {
        $syncProductsService->sync($this->user);
        $syncCostsService->sync($this->user);
        $syncPricesService->syncAll($this->user->getId());
    }
}
