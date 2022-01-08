<?php

namespace Src\Costs\Infrastructure\Container;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Src\Costs\Domain\Models\Observers\PurchaseInvoiceObserver;
use Src\Costs\Domain\Models\Observers\PurchaseItemsObserver;
use Src\costs\Domain\Models\PurchaseInvoice;
use Src\costs\Domain\Models\PurchaseItem;
use Src\Costs\Domain\Repositories\DbRepository;
use Src\Costs\Domain\Repositories\ErpRepository;
use Src\Costs\Domain\Repositories\NFeRepository;
use Src\Costs\Infrastructure\Bling\BlingRepository;
use Src\Costs\Infrastructure\Eloquent\Repository;
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
