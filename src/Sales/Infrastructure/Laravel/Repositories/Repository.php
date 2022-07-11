<?php

namespace Src\Sales\Infrastructure\Laravel\Repositories;

use Carbon\Carbon;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Sales\Domain\Events\SaleSynchronized;
use Src\Sales\Domain\Models\SaleOrder;
use Src\Sales\Domain\Repositories\Contracts\Repository as RepositoryInterface;

class Repository implements RepositoryInterface
{
    private MarketplaceRepository $marketplaceRepository;

    public function __construct(MarketplaceRepository $marketplaceRepository)
    {
        $this->marketplaceRepository = $marketplaceRepository;
    }

    public function listPaginate(
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
        $userId = auth()->user()->id;
        return SaleOrder::where('user_id', $userId)->count();
    }

    public function getLastSaleDateTime(): ?Carbon
    {
        $userId = auth()->user()->id;
        $lastUpdatedProduct = SaleOrder::query()->where('user_id', $userId)->orderByDesc('selled_at')->first();

        return $lastUpdatedProduct?->getLastUpdate();
    }
}
