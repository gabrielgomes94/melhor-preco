<?php

namespace Src\Products\Application\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Src\Products\Application\UseCases\SynchronizeProducts;

class SyncProducts implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(private string $userId)
    {
    }

    public function handle(SynchronizeProducts $synchronizeProducts): void
    {
        $synchronizeProducts->sync($this->userId);
    }
}
