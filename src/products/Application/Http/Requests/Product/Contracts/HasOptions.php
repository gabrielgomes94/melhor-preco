<?php

namespace Src\Products\Application\Http\Requests\Product\Contracts;

use Src\Products\Domain\Contracts\Utils\Options;

interface HasOptions
{
    public function getOptions(): Options;
}
