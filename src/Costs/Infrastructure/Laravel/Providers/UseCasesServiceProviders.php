<?php

namespace Src\Costs\Infrastructure\Laravel\Providers;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Src\Costs\Domain\UseCases\LinkProductToPurchaseItem as LinkProductToPurchaseItemImpl;
use Src\Costs\Domain\UseCases\SynchronizePurchaseInvoices;
use Src\Costs\Domain\UseCases\Contracts\LinkProductToPurchaseItem;
use Src\Costs\Domain\UseCases\Contracts\UpdateCosts;
use Src\Costs\Domain\UseCases\Contracts\SyncPurchaseInvoices;
use Src\Costs\Domain\UseCases\UpdateCosts as UpdateCostsImpl;

class UseCasesServiceProviders extends BaseServiceProvider
{
    public function boot()
    {
        $this->app->bind(LinkProductToPurchaseItem::class, LinkProductToPurchaseItemImpl::class);
        $this->app->bind(SyncPurchaseInvoices::class, SynchronizePurchaseInvoices::class);
        $this->app->bind(UpdateCosts::class, UpdateCostsImpl::class);
    }
}
