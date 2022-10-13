<?php

namespace Src\Sales\Infrastructure\Laravel\Presenters\SalesList;

use Illuminate\Pagination\LengthAwarePaginator;
use Src\Math\Transformers\NumberTransformer;
use Src\Sales\Domain\DataTransfer\Reports\ListReport;
use Src\Sales\Application\Reports\Data\Marketplace\MarketplaceSales;
use Src\Sales\Domain\DataTransfer\SalesFilter;
use Src\Sales\Infrastructure\Laravel\Presenters\SalesList\SalesListPresenter;

class SalesReport
{
    public function __construct(private readonly SalesListPresenter $listSalesPresenter)
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
            'paginator' => $this->getPaginator(
                $report->sales->get(),
                $report->filter,
                $report->totalSales
            ),
        ];
    }

    private function presentMetadata(ListReport $report): array
    {
        $beginDate = $report->filter->getBeginDate();
        $endDate = $report->filter->getEndDate();
        $metadata = $report->metadata;

        return [
            'beginDate' => $beginDate?->format('d/m/Y'),
            'endDate' => $endDate?->format('d/m/Y'),
            'salesCount' => $metadata->salesCount,
            'productsCount' => $metadata->productsCount,
            'storesCount' => $this->presentMarketplacesCount($metadata->marketplacesCount),
            'value' => NumberTransformer::toMoney($metadata->totalValue),
            'profit' => NumberTransformer::toMoney($metadata->totalProfit),
        ];
    }

    private function presentMarketplacesCount(array $marketplacesCount): array
    {
        $marketplacesCount = collect($marketplacesCount);

        return $marketplacesCount->mapWithKeys(
            function (MarketplaceSales $report) {
                $marketplace = $report->marketplace;
                $slug = $marketplace->getSlug();

                return [
                    $slug => [
                        'count' => collect($report->sales->get())->count(),
                        'name' => $marketplace->getName(),
                    ],
                ];
            }
        )->all();
    }

    private function getPaginator(array $sales, SalesFilter $options, int $total): LengthAwarePaginator
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
