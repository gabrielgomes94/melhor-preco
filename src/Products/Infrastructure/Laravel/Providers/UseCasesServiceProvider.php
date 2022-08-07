<?php

namespace Src\Products\Infrastructure\Laravel\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Products\Infrastructure\Laravel\Services\SynchronizeCategories;
use Src\Products\Domain\UseCases\SyncCategories;

class UseCasesServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->bind(SyncCategories::class, SynchronizeCategories::class);
    }
}
