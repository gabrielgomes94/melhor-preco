<?php

namespace Src\Prices\Application\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Src\Prices\Presentation\Components\Forms\Checkbox\Store;
use Src\Prices\Presentation\Components\PriceList\Link;
use Src\Prices\Presentation\Components\Prices\Calculator\Calculator;

class PricingServiceProvider extends ServiceProvider
{
    /**
     * Register repositories.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * @return void
     */
    public function boot()
    {
        Blade::component('pricing.forms.checkbox.store', Store::class);
        Blade::component('pricing.price-list.link', Link::class);
        Blade::component('pricing.prices.calculator.calculator', Calculator::class);
    }
}
