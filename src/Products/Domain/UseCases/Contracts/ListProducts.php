<?php

namespace Src\Products\Domain\UseCases\Contracts;

use Src\Products\Domain\Utils\Contracts\Options;

interface ListProducts
{
    public function list(Options $options): array;
}
