<?php

namespace Src\Products\Infrastructure\Laravel\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Src\Products\Domain\UseCases\SyncCategories as SyncCategoriesUseCase;
use Src\Users\Infrastructure\Laravel\Models\User;

class SyncCategories implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(private User $user)
    {
    }

    public function handle(SyncCategoriesUseCase $synchronizeCategories) {
        $synchronizeCategories->sync($this->user);
    }
}
