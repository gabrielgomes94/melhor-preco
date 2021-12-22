<?php

namespace App\View\Components\Template\Input;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;

class Percentage extends BaseInput
{
    public ?string $visibleComponentId;
    public bool $simpleInput = false;

    public function __construct(string $attribute, string $value, ?string $componentId = null, ?string $label = null)
    {
        parent::__construct($attribute, $value, $componentId, $label);

        if (!$componentId) {
            $this->simpleInput = true;
        }

        $this->visibleComponentId = $this->componentId . '-input-view';
    }

    /**
     * @return View|Htmlable|Closure|string
     */
    public function render()
    {
        return view('components.forms.input.percentage');
    }
}
