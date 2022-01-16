<?php

namespace Src\Products\Infrastructure\Laravel\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use Src\Products\Application\UseCases\SynchronizeCategories;
use Src\Products\Domain\UseCases\Contracts\SyncCategories;

class UseCasesServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->app->bind(SyncCategories::class, SynchronizeCategories::class);
    }
}
