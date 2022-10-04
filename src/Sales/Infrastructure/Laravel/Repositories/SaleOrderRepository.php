<?php

namespace Src\Sales\Infrastructure\Laravel\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Products\Domain\Repositories\ProductRepository;
use Src\Sales\Domain\DataTransfer\SalesFilter;
use Src\Sales\Infrastructure\Laravel\Models\Item;
use Src\Sales\Infrastructure\Laravel\Models\SaleOrder;
use Src\Sales\Domain\Repositories\SaleOrderRepository as SaleOrderRepositoryInterface;
use Src\Sales\Domain\Models\Contracts\SaleOrder as SaleOrderInterface;

class SaleOrderRepository implements SaleOrderRepositoryInterface
{
    public function __construct(
        private readonly MarketplaceRepository $marketplaceRepository,
        private readonly ProductRepository $productRepository
    )
    {}

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
        SaleOrderInterface $externalSaleOrder,
        string $userId
    ): void
    {
        /**
         * @var Item $item
         */
        foreach ($externalSaleOrder->getItems() as $item) {
            $product = $this->productRepository->get($item->getSku(), $userId);

            if ($product) {
                $item->product()->associate($product);
            }

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

    /**
     * @param SaleOrderInterface|SaleOrder $externalSaleOrder
     */
    public function insertSaleOrder(
        SaleOrderInterface $externalSaleOrder,
        string $userId
    ): SaleOrderInterface
    {
        $marketplace = $this->marketplaceRepository->getByErpId(
            $externalSaleOrder->store_id ?? '',
            $userId);
        $externalSaleOrder->user_id = $userId;
        $externalSaleOrder->marketplace_uuid = $marketplace?->getUuid() ?? null;
        $externalSaleOrder->uuid = Uuid::uuid4();

        $externalSaleOrder->save();

        return $externalSaleOrder;
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

    public function get(string $saleOrderId, string $userId): ?SaleOrderInterface
    {
        return SaleOrder::where('sale_order_id', $saleOrderId)
            ->where('user_id', $userId)
            ->first();
    }
}
