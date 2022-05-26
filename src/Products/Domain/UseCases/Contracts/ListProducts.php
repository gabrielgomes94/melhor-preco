<?php

namespace Src\Products\Domain\UseCases\Contracts;

use Src\Products\Application\Data\FilterOptions;
use Src\Products\Domain\DataTransfer\ProductsPaginated;

interface ListProducts
{
    public function list(FilterOptions $options): ProductsPaginated;
}
