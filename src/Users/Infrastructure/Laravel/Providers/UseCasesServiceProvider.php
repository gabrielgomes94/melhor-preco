<?php

namespace Src\Users\Infrastructure\Laravel\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Users\Infrastructure\Laravel\UseCases\GetSynchronizationInfo as GetSynchronizationInfoImpl;
use Src\Users\Domain\UseCases\GetSynchronizationInfo;

class UseCasesServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->bind(GetSynchronizationInfo::class, GetSynchronizationInfoImpl::class);
    }
}
