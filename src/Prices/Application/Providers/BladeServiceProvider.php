<?php

namespace Src\Prices\Application\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Src\Prices\Presentation\Components\Link;
use Src\Prices\Presentation\Components\Products\Table\ProductRow;
use Src\Prices\Presentation\Components\Products\Table\VariationsRow;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        Blade::component('app.pricing.price-list.link', Link::class);
        Blade::component('app.pricing.price-list.products.store-list.table.product-row', ProductRow::class);
        Blade::component('app.pricing.price-list.products.store-list.table.variations-row', VariationsRow::class);
    }
}
