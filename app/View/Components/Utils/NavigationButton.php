<?php

namespace App\View\Components\Utils;

use Illuminate\View\Component;

class NavigationButton extends Component
{
    public string $label;
    public string $route;
    public string $customStyleClass;

    /**
     * @return void
     */
    public function __construct(string $label, string $route, ?string $customStyleClass = null)
    {
        $this->label = $label;
        $this->route = $route;
        $this->customStyleClass = $customStyleClass ?? 'btn-primary';
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.utils.navigation-button');
    }
}
