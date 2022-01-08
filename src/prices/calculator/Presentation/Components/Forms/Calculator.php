<?php

namespace Src\Prices\Calculator\Presentation\Components\Forms;

use Src\Prices\Calculator\Presentation\Components\PricesComponent;

class Calculator extends PricesComponent
{
    /**
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.app.pricing.prices.calculator.forms.calculator', [
            'data' => $this->getData(),
        ]);
    }
}
