<?php

namespace App\View\Components\Forms\Input;

use Closure;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

abstract class BaseInput extends Component
{
    public string $attribute;
    public string $value;
    public ?string $componentId;
    public ?string $label;

    /**
     * @return void
     */
    public function __construct(string $attribute, string $value, ?string $componentId = null, ?string $label = null)
    {
        $this->attribute = $attribute;
        $this->componentId = $componentId ?? $attribute;
        $this->label = $label;
        $this->value = $value;
    }

    /**
     * Get the view / view contents that represent the component.
     *
     * @return View|Htmlable|Closure|string
     */
    abstract public function render();
}
