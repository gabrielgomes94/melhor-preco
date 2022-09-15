<?php

namespace Src\Sales\Infrastructure\Laravel\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Src\Sales\Infrastructure\Laravel\Services\CalculateTotalProfit;
use Src\Sales\Infrastructure\Laravel\Services\SynchronizeSales;
use Src\Sales\Domain\Repositories\ErpRepository;
use Src\Users\Domain\Repositories\Repository as UserRepository;

class SyncSales implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(private string $userId)
    {}

    public function handle(
        SynchronizeSales $synchronizeService,
        UserRepository $userRepository
    ): void
    {
        if (!$user = $userRepository->find($this->userId)) {
            return;
        }

        $synchronizeService->sync($user);
    }
}
