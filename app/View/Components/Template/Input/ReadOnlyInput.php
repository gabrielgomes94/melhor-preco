<?php

namespace App\View\Components\Template\Input;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;

class ReadOnlyInput extends BaseInput
{
    /**
     * @return View|Htmlable|Closure|string
     */
    public function render()
    {
        return view('components.bootstrap.forms.input.read-only');
    }
}
