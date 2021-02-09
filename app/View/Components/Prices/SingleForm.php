<?php

namespace App\View\Components\Prices;

use Illuminate\View\Component;

class SingleForm extends Component
{
    public $purchasePrice;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($purchasePrice)
    {
        $this->purchasePrice = $purchasePrice;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.prices.single-form');
    }
}
