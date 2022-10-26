<?php

namespace Src\Sales\Application\Repositories\Queries;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Src\Sales\Application\Models\SaleOrder;

class SalesQuery
{
    public function salesInInterval(?Carbon $beginDate = null, ?Carbon $endDate = null): Builder
    {
        $beginDate = $beginDate ?? Carbon::create(1900);
        $endDate = $endDate ?? Carbon::create(9999);

        return SaleOrder::valid()
            ->inDateInterval(
                $beginDate,
                $endDate
            )
            ->defaultOrder();
    }
}
