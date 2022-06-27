<?php

namespace Src\Products\Domain\UseCases;

use Src\Products\Domain\DataTransfer\FilterOptions;
use Src\Products\Domain\DataTransfer\ProductsPaginated;

interface ListProducts
{
    public function list(FilterOptions $options): ProductsPaginated;
}
