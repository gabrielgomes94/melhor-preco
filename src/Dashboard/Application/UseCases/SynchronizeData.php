<?php

namespace Src\Dashboard\Application\UseCases;

use Src\Costs\Application\Jobs\SyncCosts;
use Src\Products\Application\Jobs\SyncCategories;
use Src\Products\Application\Jobs\SyncProducts;
use Src\Sales\Application\Jobs\SyncSales;

class SynchronizeData
{
    public function execute()
    {
        SyncCategories::dispatch();
        SyncCosts::dispatch();
        SyncProducts::dispatch();
        SyncSales::dispatch();
    }
}
