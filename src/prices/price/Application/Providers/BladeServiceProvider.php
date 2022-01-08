<?php

namespace Src\Prices\Price\Application\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Src\Prices\Calculator\Presentation\Components\Forms\Calculator;
use Src\Prices\Calculator\Presentation\Components\Price\Card;
use Src\Prices\Calculator\Presentation\Components\UpdateCosts\Form;
use Src\Prices\Price\Presentation\Components\Link;
use Src\Prices\Price\Presentation\Components\Products\Table\ProductRow;
use Src\Prices\Price\Presentation\Components\Products\Table\VariationsRow;

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

        Blade::component('app.pricing.prices.calculator.forms.calculator', Calculator::class);
        Blade::component('app.pricing.prices.price.card', Card::class);
        Blade::component('app.pricing.prices.update-costs.form', Form::class);
    }
}
