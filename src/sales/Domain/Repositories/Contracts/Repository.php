<?php

namespace Src\Sales\Domain\Repositories\Contracts;

use Carbon\Carbon;
use Src\Sales\Domain\Models\SaleOrder;

interface Repository
{
    public const PER_PAGE = 40;

    public static function getTotalValueSum(Carbon $beginDate, Carbon $endDate);

    public static function getTotalProfitSum(Carbon $beginDate, Carbon $endDate);

    public static function listPaginate(
        Carbon $beginDate,
        Carbon $endDate,
        int $page,
        int $perPage = self::PER_PAGE,
    );

    public static function update(
        SaleOrder $saleOrder,
        ?float $profit = null,
        ?string $status = null
    ): void;
}
