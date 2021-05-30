<?php

namespace App\View\Components\Pricing\Forms\Checkbox;

use Illuminate\View\Component;

class Store extends Component
{
    public string $id;
    public string $name;
    private array $stores;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
        $this->stores = config('stores');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.pricing.forms.checkbox.store', ['stores' => $this->stores]);
    }
}
