<?php

namespace Src\Sales\Application\UseCases;

use Src\Sales\Domain\UseCases\Contracts\SyncSales as SyncSalesInterface;
use Src\Sales\Application\Jobs\SyncSales as SyncSalesJob;

class SyncSales implements SyncSalesInterface
{
    public function sync(): void
    {
        SyncSalesJob::dispatch();
    }
}
