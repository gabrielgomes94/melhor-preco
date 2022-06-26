<?php

namespace Src\Users\Infrastructure\Laravel\Services;

use Src\Costs\Infrastructure\Laravel\Jobs\SyncCosts;
use Src\Products\Infrastructure\Laravel\Jobs\SyncCategories;
use Src\Products\Infrastructure\Laravel\Jobs\SyncProducts;
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
