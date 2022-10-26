<?php

namespace Src\Users\Infrastructure\Laravel\Services;

use Src\Costs\Infrastructure\Laravel\Jobs\SyncCosts;
use Src\Products\Infrastructure\Laravel\Jobs\SyncCategories;
use Src\Products\Infrastructure\Laravel\Jobs\SyncProducts;
use Src\Sales\Application\Jobs\SyncSales;
use Src\Users\Domain\Services\SynchronizeData as SynchronizeDataInterface;

class SynchronizeData implements SynchronizeDataInterface
{
    public function execute(string $userId)
    {
        SyncCategories::dispatch($userId);
        SyncCosts::dispatch($userId);
        SyncProducts::dispatch($userId);
        SyncSales::dispatch($userId);
    }
}
