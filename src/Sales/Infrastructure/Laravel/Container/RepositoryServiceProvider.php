<?php

namespace Src\Sales\Infrastructure\Laravel\Container;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Src\Sales\Domain\Repositories\Contracts\ItemsRepository;
use Src\Sales\Domain\Repositories\Contracts\Repository;
use Src\Sales\Domain\Repositories\Contracts\SynchronizationRepository;
use Src\Sales\Infrastructure\Laravel\Repositories\ItemsRepository as ItemRepositoryImpl;
use Src\Sales\Infrastructure\Laravel\Repositories\Repository as RepositoryImpl;
use Src\Sales\Infrastructure\Laravel\Repositories\SyncRepository;

class RepositoryServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        $this->app->bind(ItemsRepository::class, ItemRepositoryImpl::class);
        $this->app->bind(Repository::class, RepositoryImpl::class);
        $this->app->bind(SynchronizationRepository::class, SyncRepository::class);
    }
}
