<?php

namespace Src\Dashboard\Infrastructure\Container;

use Illuminate\Support\ServiceProvider;
use Src\Dashboard\Application\UseCases\GetSynchronizationInfo as GetSynchronizationInfoImpl;
use Src\Dashboard\Domain\UseCases\GetSynchronizationInfo;

class UseCasesServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->bind(GetSynchronizationInfo::class, GetSynchronizationInfoImpl::class);
    }
}
