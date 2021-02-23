<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class Input extends Component
{
    public string $class;

    public string $id;

    public string $label;

    public string $name;

    public string $placeholder;

    public string $type = 'text';

    public string $value;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $name, string $label, string $id, string $placeholder, string $value, string $class)
    {
        $this->name = $name;
        $this->label = $label;
        $this->id = $id;
        $this->placeholder = $placeholder;
        $this->value = $value;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.forms.input');
    }
}
