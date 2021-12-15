<?php

namespace Src\Sales\Application\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Src\Sales\Application\Services\CalculateTotalProfit;
use Src\Sales\Application\Services\Synchronize;
use Src\Sales\Domain\Repositories\Contracts\ErpRepository;

class SyncSales implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private CalculateTotalProfit $calculateTotalProfit;

    public function handle(ErpRepository $erpRepository, Synchronize $synchronizeService): void
    {
        $data = $erpRepository->list();

        $synchronizeService->sync($data);
    }
}
