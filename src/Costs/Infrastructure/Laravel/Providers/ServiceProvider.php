<?php

namespace Src\Costs\Infrastructure\Laravel\Providers;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Src\Costs\Infrastructure\Laravel\Models\Observers\PurchaseInvoiceObserver;
use Src\Costs\Infrastructure\Laravel\Models\Observers\PurchaseItemsObserver;
use Src\Costs\Infrastructure\Laravel\Models\PurchaseInvoice;
use Src\Costs\Infrastructure\Laravel\Models\PurchaseItem;
use Src\Costs\Domain\Repositories\DbRepository;
use Src\Costs\Domain\Repositories\ErpRepository;
use Src\Costs\Domain\Repositories\NFeRepository;
use Src\Costs\Infrastructure\Bling\BlingRepository;
use Src\Costs\Infrastructure\Laravel\Repositories\Repository;
use Src\Costs\Infrastructure\NFe\XmlReader;

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        PurchaseInvoice::observe(PurchaseInvoiceObserver::class);
        PurchaseItem::observe(PurchaseItemsObserver::class);

        $this->app->bind(ErpRepository::class, BlingRepository::class);
        $this->app->bind(DbRepository::class, Repository::class);
        $this->app->bind(NFeRepository::class, XmlReader::class);
    }
}
