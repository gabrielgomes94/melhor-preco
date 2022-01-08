<?php

namespace Src\Costs\Infrastructure;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Src\Costs\Domain\Models\Observers\PurchaseInvoiceObserver;
use Src\Costs\Domain\Models\Observers\PurchaseItemsObserver;
use Src\costs\Domain\Models\PurchaseInvoice;
use Src\costs\Domain\Models\PurchaseItems;
use Src\Costs\Domain\Repositories\DbRepository;
use Src\Costs\Domain\Repositories\ErpRepository;
use Src\Costs\Infrastructure\Bling\BlingRepository;
use Src\Costs\Infrastructure\Eloquent\Repository;

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        PurchaseInvoice::observe(PurchaseInvoiceObserver::class);
        PurchaseItems::observe(PurchaseItemsObserver::class);

        $this->app->bind(ErpRepository::class, BlingRepository::class);
        $this->app->bind(DbRepository::class, Repository::class);
    }
}
