<?php

namespace Src\Prices\PriceList\Application\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Src\Prices\PriceList\Presentation\Components\Link;
use Src\Prices\PriceList\Presentation\Components\Products\Table\ProductRow;
use Src\Prices\PriceList\Presentation\Components\Products\Table\VariationsRow;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        Blade::component('pricing.price-list.link', Link::class);
        Blade::component('pricing.price-list.products.store-list.table.product-row', ProductRow::class);
        Blade::component('pricing.price-list.products.store-list.table.variations-row', VariationsRow::class);
    }
}
