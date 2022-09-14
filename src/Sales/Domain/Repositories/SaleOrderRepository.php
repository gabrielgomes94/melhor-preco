<?php

namespace Src\Sales\Domain\Repositories;

use Carbon\Carbon;
use Src\Sales\Domain\DataTransfer\SalesFilter;
use Src\Sales\Domain\Models\Contracts\SaleOrder;

interface SaleOrderRepository
{
    public function getLastSaleDateTime(string $userId): ?Carbon;

    public function countSales(SalesFilter $options): int;

    public function listPaginate(SalesFilter $options);

    public function insertSaleInvoice(SaleOrder $internalSaleOrder, SaleOrder $externalSaleOrder): void;

    public function insertSaleItems(SaleOrder $internalSaleOrder, SaleOrder $externalSaleOrder): void;

    public function insertSaleOrder(SaleOrder $externalSaleOrder, string $userId): SaleOrder;

    public function insertShipment(SaleOrder $internalSaleOrder, SaleOrder $externalSaleOrder): void;

    public function updateProfit(SaleOrder $saleOrder, string $profit): bool;

    public function updateStatus(SaleOrder $saleOrder, string $status): bool;
}
