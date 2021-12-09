<?php

namespace Src\Sales\Infrastructure\Eloquent;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Src\Sales\Domain\Repositories\Contracts\ItemsRepository;
use Src\Sales\Domain\Repositories\Contracts\Repository;
use Src\Sales\Domain\Repositories\Contracts\SynchronizationRepository;
use Src\Sales\Infrastructure\Eloquent\Repositories\ItemsRepository as ItemRepositoryImpl;
use Src\Sales\Infrastructure\Eloquent\Repositories\Repository as RepositoryImpl;
use Src\Sales\Infrastructure\Eloquent\Repositories\SyncRepository;

class RepositoryServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        $this->app->bind(ItemsRepository::class, ItemRepositoryImpl::class);
        $this->app->bind(Repository::class, RepositoryImpl::class);
        $this->app->bind(SynchronizationRepository::class, SyncRepository::class);
    }
}
