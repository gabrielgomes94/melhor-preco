<?php

namespace Src\Sales\Infrastructure\Laravel\Presenters\SalesList;

use Illuminate\Pagination\LengthAwarePaginator;
use Src\Math\Transformers\NumberTransformer;
use Src\Sales\Application\Reports\Data\Sales\SalesList;
use Src\Sales\Domain\DataTransfer\Reports\ListReport;
use Src\Sales\Application\Reports\Data\Marketplace\MarketplaceSales;
use Src\Sales\Domain\DataTransfer\SalesFilter;
use Src\Sales\Infrastructure\Laravel\Presenters\SalesList\SalesListPresenter;

class SalesReportPresenter
{
    public function __construct(private readonly SalesListPresenter $listSalesPresenter)
    {
    }

    public function present(SalesList $report, SalesFilter $filter): array
    {
        return [
            'saleOrders' => $this->listSalesPresenter->listSaleOrder(
                $report->getSaleOrders(),
                $filter->getUserId()
            ),
            'total' => $this->presentMetadata($report, $filter),
            'paginator' => $report->paginator,
        ];
    }

    private function presentMetadata(SalesList $report, SalesFilter $filter): array
    {
        $beginDate = $filter->getBeginDate();
        $endDate = $filter->getEndDate();

        return [
            'beginDate' => $beginDate?->format('d/m/Y'),
            'endDate' => $endDate?->format('d/m/Y'),
            'salesCount' => $report->count(),
            'productsCount' => $report->getProductsCount(),
            'storesCount' => $this->presentMarketplacesCount($report->marketplaceSales),
            'value' => NumberTransformer::toMoney($report->getTotalValue()),
            'profit' => NumberTransformer::toMoney($report->getTotalProfit()),
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
