<?php

namespace Src\Costs\Infrastructure\Laravel\Providers;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Src\Costs\Domain\Services\LinkProductToPurchaseItem;
use Src\Costs\Domain\Services\SyncPurchaseInvoices;
use Src\Costs\Domain\Services\UpdateCosts;
use Src\Costs\Domain\UseCases\LinkProductToPurchaseItem as LinkProductToPurchaseItemImpl;
use Src\Costs\Infrastructure\Laravel\Services\SynchronizePurchaseInvoices;
use Src\Costs\Infrastructure\Laravel\Services\UpdateCosts as UpdateCostsImpl;
use Src\Costs\Infrastructure\Laravel\Models\Observers\PurchaseInvoiceObserver;
use Src\Costs\Infrastructure\Laravel\Models\Observers\PurchaseItemsObserver;
use Src\Costs\Infrastructure\Laravel\Models\PurchaseInvoice;
use Src\Costs\Infrastructure\Laravel\Models\PurchaseItem;
use Src\Costs\Domain\Repositories\DbRepository;
use Src\Costs\Domain\Repositories\ErpRepository;
use Src\Costs\Domain\Repositories\NFeRepository;
use Src\Costs\Infrastructure\Bling\BlingRepository;
use Src\Costs\Infrastructure\Laravel\Repositories\Repository;
use Src\Costs\Infrastructure\NFe\Repository as NFeRepositoryImplementation;

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        PurchaseInvoice::observe(PurchaseInvoiceObserver::class);
        PurchaseItem::observe(PurchaseItemsObserver::class);

        $this->bindRepositories();
        $this->bindUseCases();
    }

    private function bindUseCases(): void
    {
        $this->app->bind(LinkProductToPurchaseItem::class, LinkProductToPurchaseItemImpl::class);
        $this->app->bind(SyncPurchaseInvoices::class, SynchronizePurchaseInvoices::class);
        $this->app->bind(UpdateCosts::class, UpdateCostsImpl::class);
    }

    public function bindRepositories(): void
    {
        $this->app->bind(ErpRepository::class, BlingRepository::class);
        $this->app->bind(DbRepository::class, Repository::class);
        $this->app->bind(NFeRepository::class, NFeRepositoryImplementation::class);
    }
}
