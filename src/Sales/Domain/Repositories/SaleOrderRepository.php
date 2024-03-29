<?php

namespace Src\Sales\Domain\Repositories;

use Carbon\Carbon;
use Src\Sales\Domain\DataTransfer\SalesFilter;
use Src\Sales\Domain\Models\Contracts\SaleOrder;

interface SaleOrderRepository
{
    public function get(string $saleOrderId, string $userId): ?SaleOrder;

    public function getLastSaleDateTime(string $userId): ?Carbon;

    public function countSales(string $userId, ?Carbon $beginDate = null, ?Carbon $endDate = null): int;

    public function list(
        string $userId,
        ?Carbon $beginDate = null,
        ?Carbon $endDate = null
    ): array;

    public function listPaginate(SalesFilter $filter);

    public function insertSaleInvoice(SaleOrder $internalSaleOrder, SaleOrder $externalSaleOrder): void;

    public function insertSaleItems(SaleOrder $internalSaleOrder, SaleOrder $externalSaleOrder, string $userId): void;

    public function insertSaleOrder(SaleOrder $externalSaleOrder, string $userId): SaleOrder;

    public function insertShipment(SaleOrder $internalSaleOrder, SaleOrder $externalSaleOrder): void;

    public function updateProfit(SaleOrder $saleOrder, float $profit): bool;

    public function updateStatus(SaleOrder $saleOrder, string $status): bool;
}
