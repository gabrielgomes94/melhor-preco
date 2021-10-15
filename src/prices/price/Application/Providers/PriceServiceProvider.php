<?php

namespace Src\Prices\Price\Application\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Src\Prices\PriceList\Presentation\Components\Link;
use Src\Prices\PriceList\Presentation\Components\Products\Table\ProductRow;
use Src\Prices\PriceList\Presentation\Components\Products\Table\VariationsRow;
use Src\Prices\Calculator\Presentation\Components\Forms\Calculator;
use Src\Prices\Calculator\Presentation\Components\Price\Card;
use Src\Prices\Calculator\Presentation\Components\UpdateCosts\Form;

class PriceServiceProvider extends ServiceProvider
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
        Blade::component('pricing.prices.calculator.forms.calculator', Calculator::class);
        Blade::component('pricing.prices.price.card', Card::class);
        Blade::component('pricing.prices.update-costs.form', Form::class);
    }
}
