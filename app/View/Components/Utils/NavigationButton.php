<?php

namespace App\View\Components\Utils;

use Illuminate\View\Component;

class NavigationButton extends Component
{
    public string $label;
    public string $route;

    /**
     * @return void
     */
    public function __construct(string $label, string $route)
    {
        $this->label = $label;
        $this->route = $route;
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.utils.navigation-button');
    }
}
