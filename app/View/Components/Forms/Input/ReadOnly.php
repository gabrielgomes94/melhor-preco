<?php

namespace App\View\Components\Forms\Input;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;

class ReadOnly extends BaseInput
{
    /**
     * @return View|Htmlable|Closure|string
     */
    public function render()
    {
        return view('components.forms.input.read-only');
    }
}
