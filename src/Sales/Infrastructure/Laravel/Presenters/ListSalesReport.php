<?php

namespace Src\Sales\Infrastructure\Laravel\Presenters;

use Illuminate\Pagination\LengthAwarePaginator;
use Src\Math\MathPresenter;
use Src\Sales\Domain\DataTransfer\Reports\ListReport;
use Src\Sales\Domain\DataTransfer\Reports\MarketplaceSalesReport;
use Src\Sales\Domain\UseCases\Contracts\Filters\ListSalesFilter;

class ListSalesReport
{
    public function __construct(private readonly ListSalesPresenter $listSalesPresenter)
    {
    }

    public function present(ListReport $report): array
    {
        return [
            'saleOrders' => $this->listSalesPresenter->listSaleOrder(
                $report->sales,
                $report->filter->getUserId()
            ),
            'total' => $this->presentMetadata($report),
            'paginator' => $this->getPaginator($report->sales, $report->filter, $report->totalSales),
        ];
    }

    private function presentMetadata(ListReport $report): array
    {
        $beginDate = $report->filter->getBeginDate();
        $endDate = $report->filter->getEndDate();
        $metadata = $report->metadata;

        return [
            'beginDate' => $beginDate->format('d/m/Y'),
            'endDate' => $endDate->format('d/m/Y'),
            'salesCount' => $metadata->salesCount,
            'productsCount' => $metadata->productsCount,
            'storesCount' => $this->presentMarketplacesCount($metadata->marketplacesCount),
            'value' => MathPresenter::money($metadata->totalValue),
            'profit' => MathPresenter::money($metadata->totalProfit),
        ];
    }

    private function presentMarketplacesCount(array $marketplacesCount): array
    {
        $marketplacesCount = collect($marketplacesCount);

        return $marketplacesCount->mapWithKeys(
            function(MarketplaceSalesReport $report) {
                $marketplace = $report->marketplace;
                $slug = $marketplace->getSlug();

                return [
                    $slug => [
                        'count' => $report->salesCount,
                        'name' => $marketplace->getName(),
                    ],
                ];
        })->all();
    }

    private function getPaginator(array $sales, ListSalesFilter $options, int $total): LengthAwarePaginator
    {
        return new LengthAwarePaginator(
            $sales,
            $total,
            $options->getPerPage(),
            $options->getPage(),
            [
                'path' => $options->getUrl(),
            ]
        );
    }
}
