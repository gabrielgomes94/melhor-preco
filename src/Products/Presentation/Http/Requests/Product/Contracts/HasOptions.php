<?php

namespace Src\Products\Presentation\Http\Requests\Product\Contracts;

use Src\Products\Domain\Utils\Contracts\Options;

interface HasOptions
{
    public function getOptions(): Options;
}
