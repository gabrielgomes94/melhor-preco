<?php

namespace Src\Products\Infrastructure\Laravel\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use Src\Products\Application\UseCases\SynchronizeProducts;
use Src\Products\Domain\UseCases\Contracts\SyncProducts;
use Src\Products\Infrastructure\Laravel\Services\SynchronizeCategories;
use Src\Products\Domain\UseCases\Contracts\SyncCategories;

class UseCasesServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->bind(SyncCategories::class, SynchronizeCategories::class);
        $this->app->bind(SyncProducts::class, SynchronizeProducts::class);
    }
}
