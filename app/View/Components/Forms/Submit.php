<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class Submit extends Component
{
    public string $label;
    public string $width;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $label, string $width = '')
    {
        $this->label = $label;
        $this->width = 'w-'.($width ?? '100');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.forms.submit');
    }
}
