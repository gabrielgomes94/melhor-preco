<?php

namespace Src\Products\Application\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Src\Products\Domain\UseCases\Contracts\SyncCategories as SyncCategoriesUseCase;

class SyncCategories implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function handle(SyncCategoriesUseCase $synchronizeCategories) {
        $synchronizeCategories->sync();
    }
}
