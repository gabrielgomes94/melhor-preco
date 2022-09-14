<?php

namespace Src\Sales\Infrastructure\Laravel\Repositories;

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use Src\Sales\Domain\DataTransfer\SalesFilter;
use Src\Sales\Infrastructure\Laravel\Models\SaleOrder;
use Src\Sales\Domain\Repositories\SaleOrderRepository as SaleOrderRepositoryInterface;
use Src\Sales\Domain\Models\Contracts\SaleOrder as SaleOrderInterface;

class SaleOrderRepository implements SaleOrderRepositoryInterface
{
    public function getLastSaleDateTime(string $userId): ?Carbon
    {
        $lastUpdatedProduct = SaleOrder::where('user_id', $userId)
            ->orderByDesc('selled_at')
            ->first();

        return $lastUpdatedProduct?->getLastUpdate();
    }

    public function countSales(SalesFilter $options): int
    {
        return SaleOrder::where('user_id', $options->getUserId())
            ->valid()
            ->inDateInterval(
                $options->getBeginDate(),
                $options->getEndDate()
            )
            ->count();
    }

    public function listPaginate(SalesFilter $options)
    {
        return SaleOrder::valid()
            ->inDateInterval(
                $options->getBeginDate(),
                $options->getEndDate()
            )
            ->defaultOrder()
            ->paginate(
                page: $options->getPage(),
                perPage: $options->getPerPage()
            );
    }

    public function insertSaleInvoice(
        SaleOrderInterface $internalSaleOrder,
        SaleOrderInterface $externalSaleOrder
    ): void
    {
        $invoice = $externalSaleOrder->getInvoice();

        if (!$invoice) {
            return;
        }

        $internalSaleOrder->invoice()->save($invoice);
    }

    public function insertSaleItems(
        SaleOrderInterface $internalSaleOrder,
        SaleOrderInterface $externalSaleOrder
    ): void
    {
        foreach ($externalSaleOrder->getItems() as $item) {
            $internalSaleOrder->items()->save($item);
        }
    }

    public function insertShipment(
        SaleOrderInterface $internalSaleOrder,
        SaleOrderInterface $externalSaleOrder
    ): void
    {
        if (!$shipment = $externalSaleOrder->getShipment()) {
            return;
        }

        $internalSaleOrder->shipment()->save($shipment);
    }

    public function insertSaleOrder(
        SaleOrderInterface $externalSaleOrder,
        string $userId
    ): SaleOrderInterface
    {
        $internalSaleOrder = $externalSaleOrder;
        $internalSaleOrder->user_id = $userId;
        $internalSaleOrder->uuid = Uuid::uuid4();
        $internalSaleOrder->save();

        return $internalSaleOrder;
    }

    public function updateProfit(SaleOrderInterface $saleOrder, string $profit): bool
    {
        $saleOrder->total_profit = $profit;

        return $saleOrder->save();
    }

    public function updateStatus(SaleOrderInterface $saleOrder, string $status): bool
    {
        $saleOrder->setStatus($status);

        return $saleOrder->save();
    }
}
