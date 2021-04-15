<?php

namespace App\View\Components\Forms\Input;

use Illuminate\View\Component;

class Percentage extends SimpleInput
{
    /**
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.forms.input.percentage');
    }
}
