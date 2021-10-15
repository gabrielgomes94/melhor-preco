<?php

namespace Src\Prices\Calculator\Presentation\Components\Forms;

use Illuminate\View\Component;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Src\Prices\Calculator\Domain\PostPriced\PostPriced;
use Src\Prices\Calculator\Presentation\Components\PricesComponent;

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
