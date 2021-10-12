<?php

namespace Src\Prices\Presentation\Components\Prices\Calculator\Forms;

use Illuminate\View\Component;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Src\Prices\Domain\PostPriced\PostPriced;
use Src\Prices\Presentation\Components\Prices\PricesComponent;

class Calculator extends PricesComponent
{
    /**
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.pricing.prices.calculator.forms.calculator');
    }
}
