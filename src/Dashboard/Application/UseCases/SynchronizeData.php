<?php

namespace Src\Dashboard\Application\UseCases;

use Src\Costs\Infrastructure\Laravel\Jobs\SyncCosts;
use Src\Products\Application\Jobs\SyncCategories;
use Src\Products\Application\Jobs\SyncProducts;
use Src\Sales\Application\Jobs\SyncSales;

class SynchronizeData
{
    public function execute(string $userId)
    {
        SyncCategories::dispatch($userId);
        SyncCosts::dispatch($userId);
        SyncProducts::dispatch($userId);
        SyncSales::dispatch($userId);
    }
}
