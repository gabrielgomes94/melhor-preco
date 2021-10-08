<?php

namespace Src\Prices\Application\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Src\Prices\Presentation\Components\Forms\Checkbox\Store;
use Src\Prices\Presentation\Components\PriceList\Link;
use Src\Prices\Presentation\Components\PriceList\Products\Table\ProductRow;
use Src\Prices\Presentation\Components\PriceList\Products\Table\VariationsRow;
use Src\Prices\Presentation\Components\Prices\Calculator\Forms\Calculator;
use Src\Prices\Presentation\Components\Prices\Price\Card;
use Src\Prices\Presentation\Components\Prices\UpdateCosts\Form;

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
        Blade::component('pricing.price-list.products.store-list.table.product-row', ProductRow::class);
        Blade::component('pricing.price-list.products.store-list.table.variations-row', VariationsRow::class);
        Blade::component('pricing.prices.calculator.forms.calculator', Calculator::class);
        Blade::component('pricing.prices.price.card', Card::class);
        Blade::component('pricing.prices.update-costs.form', Form::class);
    }
}
