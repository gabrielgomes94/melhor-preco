<?php

namespace App\View\Components\Pricing\Forms\Checkbox;

use Illuminate\View\Component;

class Store extends Component
{
    public string $id;
    public string $name;

    private array $stores = [
        [
            'code' => 'magalu',
            'name' => 'Magazine Luiza',
            'commission' => 12.8,
        ],
        [
            'code' => 'mercado_livre',
            'name' => 'Mercado Livre',
            'commission' => 16.1,
        ],
        [
            'code' => 'b2w',
            'name' => 'B2W',
            'commission' => 16.2,
        ],
        [
            'code' => 'shopee',
            'name' => 'Shopee',
            'commission' => 5,
        ],
        [
            'code' => 'olist',
            'name' => 'Olist',
            'commission' => 20,
        ],
    ];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
        //
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
