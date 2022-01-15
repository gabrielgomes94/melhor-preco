<?php

namespace Src\Sales\Domain\UseCases\Contracts;

use Src\Sales\Domain\UseCases\Contracts\Filters\ListSalesFilter;

interface ListSales
{
    public function list(ListSalesFilter $options): array;
}
