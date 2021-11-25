<?php

namespace Src\Products\Application\Http\Requests\Product\Contracts;

use Src\Products\Domain\Utils\Contracts\Options;

interface HasOptions
{
    public function getOptions(): Options;
}
