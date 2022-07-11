<?php

namespace Src\Sales\Infrastructure\Laravel\Repositories\Queries;

use Illuminate\Database\Eloquent\Builder;
use Src\Sales\Domain\DataTransfer\SalesFilter;
use Src\Sales\Domain\Models\SaleOrder;

class SalesQuery
{
    public static function salesInInterval(SalesFilter $options): Builder
    {
        return SaleOrder::valid()
            ->inDateInterval(
                $options->getBeginDate(),
                $options->getEndDate()
            )
            ->defaultOrder();

    }
}
