<?php

namespace Src\Products\Infrastructure\Laravel\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Products\Infrastructure\Laravel\Services\SynchronizeData;
use Src\Products\Domain\UseCases\Contracts\SyncProducts;
use Src\Products\Infrastructure\Laravel\Services\SynchronizeCategories;
use Src\Products\Domain\UseCases\Contracts\SyncCategories;

class UseCasesServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->bind(SyncCategories::class, SynchronizeCategories::class);
        $this->app->bind(SyncProducts::class, SynchronizeData::class);
    }
}
