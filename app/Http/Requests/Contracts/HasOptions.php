<?php

namespace App\Http\Requests\Contracts;

use Barrigudinha\Product\Utils\Contracts\Options;

interface HasOptions
{
    public function getOptions(): Options;
}
