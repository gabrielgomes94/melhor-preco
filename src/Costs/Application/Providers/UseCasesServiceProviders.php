<?php

namespace Src\Costs\Application\Providers;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Src\Costs\Application\UseCases\SynchronizePurchaseInvoices;
use Src\Costs\Domain\UseCases\Contracts\UpdateCosts;
use Src\costs\Domain\UseCases\SyncPurchaseInvoices;
use Src\Costs\Application\UseCases\UpdateCosts as UpdateCostsImpl;

class UseCasesServiceProviders extends BaseServiceProvider
{
    public function boot()
    {
        $this->app->bind(SyncPurchaseInvoices::class, SynchronizePurchaseInvoices::class);
        $this->app->bind(UpdateCosts::class, UpdateCostsImpl::class);
    }
}
