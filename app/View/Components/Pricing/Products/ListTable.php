<?php

namespace App\View\Components\Pricing\Products;

use Illuminate\View\Component;

class ListTable extends Component
{
    public array $products;

    public array $stores;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(array $pricing)
    {
        $this->products = $pricing['products'] ?? [];
        $this->stores = $pricing['stores'] ?? [];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.pricing.products.list-table');
    }
}