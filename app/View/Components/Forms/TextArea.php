<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class TextArea extends Component
{
    public string $id;

    public string $label;

    public string $name;

    public string $value;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $id, string $name, string $label, string $value)
    {
        $this->name = $name;
        $this->label = $label;
        $this->id = $id;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.forms.text-area');
    }
}
