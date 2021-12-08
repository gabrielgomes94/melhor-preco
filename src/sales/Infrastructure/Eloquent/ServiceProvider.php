<?php

namespace Src\Sales\Infrastructure\Eloquent;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Src\Sales\Domain\Repositories\Contracts\ItemRepository;
use Src\Sales\Infrastructure\Eloquent\Repositories\ItemsRepository as ItemRepositoryImpl;
use Src\Sales\Domain\Repositories\Contracts\SynchronizationRepository;
use Src\Sales\Infrastructure\Eloquent\Repositories\SyncRepository;
use Src\Sales\Domain\Repositories\Contracts\Repository;
use Src\Sales\Infrastructure\Eloquent\Repositories\Repository as RepositoryImpl;

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        $this->app->bind(ItemRepository::class, ItemRepositoryImpl::class);

        $this->app->bind(SynchronizationRepository::class, SyncRepository::class);

        $this->app->bind(Repository::class, RepositoryImpl::class);
    }
}
