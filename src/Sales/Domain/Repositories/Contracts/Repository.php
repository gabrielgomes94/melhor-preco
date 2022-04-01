<?php

namespace Src\Sales\Domain\Repositories\Contracts;

use Carbon\Carbon;
use Src\Products\Domain\Models\Product\Contracts\Product;
use Src\Sales\Domain\Models\SaleOrder;

interface Repository
{
    public const PER_PAGE = 40;

    public function getTotalValueSum(Carbon $beginDate, Carbon $endDate);

    public function getTotalProfitSum(Carbon $beginDate, Carbon $endDate);

    public function listPaginate(
        Carbon $beginDate,
        Carbon $endDate,
        int $page,
        int $perPage = self::PER_PAGE,
    );

    public function update(
        SaleOrder $saleOrder,
        ?float $profit = null,
        ?string $status = null
    ): void;

    public function countSales(): int;

    public function getLastSaleDateTime(): ?Carbon;
}
