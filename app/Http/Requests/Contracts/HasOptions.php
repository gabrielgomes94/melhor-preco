<?php

namespace App\Http\Requests\Contracts;

use Src\Products\Domain\Contracts\Utils\Options;

interface HasOptions
{
    public function getOptions(): Options;
}
