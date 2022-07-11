<?php

namespace Src\Sales\Domain\Repositories;

use Carbon\Carbon;
//use Src\Products\Domain\DataTransfer\FilterOptions;
use Src\Sales\Domain\DataTransfer\SalesFilter;
use Src\Sales\Domain\Models\Contracts\SaleOrder as SaleOrderInterface;
use Src\Sales\Domain\Models\SaleOrder;

interface SaleOrderRepository
{
    public function getLastSaleDateTime(string $userId): ?Carbon;

    public function countSales(SalesFilter $options): int;

    public function listPaginate(SalesFilter $options);

    public function syncCustomer(SaleOrder $internalSaleOrder, SaleOrderInterface $externalSaleOrder): void;

    public function syncInvoice(SaleOrder $internalSaleOrder, SaleOrderInterface $externalSaleOrder): void;

    public function syncItems(SaleOrder $internalSaleOrder, SaleOrderInterface $externalSaleOrder): void;

    public function syncSaleOrder(SaleOrderInterface $externalSaleOrder, string $userId): SaleOrder;

    public function syncShipment(SaleOrder $internalSaleOrder, SaleOrderInterface $externalSaleOrder): void;

    public function updateProfit(SaleOrder $saleOrder, string $profit): bool;

    public function updateStatus(SaleOrder $saleOrder, string $status): bool;
}
