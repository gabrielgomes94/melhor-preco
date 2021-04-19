<?php


namespace App\View\Components\Forms\Input;


use Illuminate\View\Component;

abstract class SimpleInput extends Component
{
    public string $id;
    public string $label;
    public string $name;
    public string $attribute;
    public string $value;

    /**
     * @return void
     */
    public function __construct(string $attribute, string $label, string $value, string $id = null)
    {
        $this->attribute = $attribute;
        $this->label = $label;
        $this->value = $value;
        $this->id = $id ?? $attribute;
        $this->name = $attribute;
    }

    /**
     * Get the view / view contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\Support\Htmlable|\Closure|string
     */
    abstract public function render();
}
