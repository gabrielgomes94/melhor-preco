<?php

namespace Src\Products\Infrastructure\Laravel\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Src\Products\Infrastructure\Laravel\Services\SynchronizeData;
use Src\Users\Domain\Entities\User;

class SyncProducts implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(private User $user)
    {
    }

    public function handle(SynchronizeData $synchronizeProducts): void
    {
        $synchronizeProducts->sync($this->user);
    }
}
