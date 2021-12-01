<?php

namespace Src\Products\Application\UseCases;

use Src\Prices\Price\Application\Jobs\SyncPrices;
use Src\Products\Application\Jobs\SyncProducts;
use Src\Products\Domain\UseCases\Contracts\SyncProducts as SyncProductsInterface;

class SynchronizeProducts implements SyncProductsInterface
{
    public function sync(): void
    {
        SyncProducts::dispatch();
        SyncPrices::dispatch();
    }
}
