<?php

namespace Src\Sales\Infrastructure\Eloquent\Repositories;

use Carbon\Carbon;
use Src\Products\Domain\Models\Product\Product;
use Src\Products\Infrastructure\Config\StoreRepository;
use Src\Sales\Domain\Events\SaleSynchronized;
use Src\Sales\Domain\Models\SaleOrder;
use Src\Sales\Domain\Repositories\Contracts\Repository as RepositoryInterface;
use function event;

class Repository implements RepositoryInterface
{
    public static function listPaginate(
        Carbon $beginDate,
        Carbon $endDate,
        int $page,
        int $perPage = RepositoryInterface::PER_PAGE
    ) {
        return SaleOrder::valid()
            ->inDateInterval($beginDate, $endDate)
            ->defaultOrder()
            ->paginate(page: $page, perPage: $perPage);
    }

    public static function getTotalValueSum(Carbon $beginDate, Carbon $endDate)
    {
        return SaleOrder::valid()
            ->inDateInterval($beginDate, $endDate)
            ->sum('total_value');
    }

    public static function getTotalProfitSum(Carbon $beginDate, Carbon $endDate)
    {
        return SaleOrder::valid()
            ->inDateInterval($beginDate, $endDate)
            ->sum('total_profit');
    }

    public static function getTotalSalesCount(Carbon $beginDate, Carbon $endDate)
    {
        return SaleOrder::valid()
            ->inDateInterval($beginDate, $endDate)
            ->count();
    }

    public static function getTotalProductsCount(Carbon $beginDate, Carbon $endDate)
    {
        return SaleOrder::withCount('items')
            ->inDateInterval($beginDate, $endDate)
            ->count();
    }

    public static function getTotalStoresCount(Carbon $beginDate, Carbon $endDate)
    {
        $stores = StoreRepository::all();

        foreach ($stores as $store) {
            $slug = $store->getSlug();

            $storeList[$slug] = [
                'count' => SaleOrder::valid()
                    ->inDateInterval($beginDate, $endDate)
                    ->where('store_id', $store->getErpCode())
                    ->count(),
                'name' => $store->getName(),
            ];
        }

        return $storeList ?? [];
    }

    public function update(SaleOrder $saleOrder, ?float $profit = null, ?string $status = null): void
    {
        if (isset($profit)) {
            $saleOrder->total_profit = $profit;
        }

        if (isset($status)) {
            $saleOrder->status = $status;
        }

        if ($saleOrder->save()) {
            event(new SaleSynchronized($saleOrder->id));
        }
    }

    public function countSales(): int
    {
        return SaleOrder::count();
    }

    public function getLastSaleDateTime(): ?Carbon
    {
        $lastUpdatedProduct = SaleOrder::query()->orderByDesc('selled_at')->first();

        return $lastUpdatedProduct?->getLastUpdate();
    }
}