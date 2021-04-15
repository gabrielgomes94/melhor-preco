<?php

namespace App\View\Components\Forms\Input;

use Illuminate\View\Component;

class ReadOnly extends Component
{
    public string $id;
    public string $attribute;
    public string $label;
    public string $name;
    public string $value;

    /**
     * @return void
     */
    public function __construct(string $attribute, string $label, ?string $value = '0.0')
    {
        $this->attribute = $attribute;
        $this->label = $label;
        $this->value = $value;
        $this->id = $attribute;
        $this->name = $attribute;
    }

    /**
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.forms.input.read-only');
    }
}
