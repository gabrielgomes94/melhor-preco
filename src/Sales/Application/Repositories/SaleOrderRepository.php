<?php

namespace Src\Sales\Application\Repositories;

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Products\Domain\Repositories\ProductRepository;
use Src\Sales\Application\Repositories\Queries\SalesQuery;
use Src\Sales\Domain\DataTransfer\SalesFilter;
use Src\Sales\Infrastructure\Laravel\Models\Item;
use Src\Sales\Infrastructure\Laravel\Models\SaleOrder;
use Src\Sales\Domain\Repositories\SaleOrderRepository as SaleOrderRepositoryInterface;
use Src\Sales\Domain\Models\Contracts\SaleOrder as SaleOrderInterface;

class SaleOrderRepository implements SaleOrderRepositoryInterface
{
    public function __construct(
        private readonly MarketplaceRepository $marketplaceRepository,
        private readonly ProductRepository $productRepository,
        private readonly SalesQuery $salesQuery
    )
    {}

    public function getLastSaleDateTime(string $userId): ?Carbon
    {
        $lastUpdatedProduct = SaleOrder::where('user_id', $userId)
            ->orderByDesc('selled_at')
            ->first();

        return $lastUpdatedProduct?->getLastUpdate();
    }

    public function countSales(string $userId, ?Carbon $beginDate = null, ?Carbon $endDate = null): int
    {
        return $this->salesQuery->salesInInterval($beginDate, $endDate)
            ->where('user_id', $userId)
            ->count();
    }

    public function listPaginate(SalesFilter $filter)
    {
        return $this->salesQuery->salesInInterval(
            $filter->getBeginDate(),
            $filter->getEndDate()
        )->where('user_id', $filter->getUserId())
            ->paginate(
            perPage: $filter->getPerPage(),
            page: $filter->getPage()
        );
    }

    public function list(
        string $userId,
        ?Carbon $beginDate = null,
        ?Carbon $endDate = null
    ): array
    {
        return $this->salesQuery->salesInInterval(
            $beginDate,
            $endDate
        )->where('user_id', $userId)
            ->get()
            ->all();
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

    public function updateProfit(SaleOrderInterface $saleOrder, float $profit): bool
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
