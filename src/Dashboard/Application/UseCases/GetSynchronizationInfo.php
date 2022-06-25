<?php

namespace Src\Dashboard\Application\UseCases;

use Carbon\Carbon;
use Src\Costs\Domain\Repositories\DbRepository;
use Src\Dashboard\Domain\UseCases\GetSynchronizationInfo as GetSynchronizationInfoInterface;
use Src\Products\Domain\Repositories\ProductRepository;
use Src\Sales\Domain\Repositories\Contracts\Repository as SalesRepository;

class GetSynchronizationInfo implements GetSynchronizationInfoInterface
{
    private SalesRepository $salesRepository;
    private ProductRepository $repository;
    private DbRepository $costsRepository;

    private const DATE_FORMAT = 'd-m-Y H:i:s';

    public function __construct(
        ProductRepository $repository,
        DbRepository $costsRepository,
        SalesRepository $salesRepository
    ) {
        $this->repository = $repository;
        $this->costsRepository = $costsRepository;
        $this->salesRepository = $salesRepository;
    }

    public function get(): array
    {
        return [
            'products' => [
                'syncedQuantity' => $this->repository->count(),
                'activeQuantity' => $this->repository->countActives(),
                'lastUpdatedAt' => $this->formatDate(
                    $this->costsRepository->getLastSynchronizationDateTime()
                ),
            ],
            'invoices' => [
                'syncedQuantity' => $this->costsRepository->countPurchaseInvoices(),
                'lastUpdatedAt' => $this->formatDate(
                    $this->costsRepository->getLastSynchronizationDateTime()
                ),
            ],
            'sales' => [
                'syncedQuantity' => $this->salesRepository->countSales(),
                'lastUpdatedAt' => $this->formatDate(
                    $this->salesRepository->getLastSaleDateTime()
                ),
            ],
        ];
    }

    private function formatDate(?Carbon $date): string
    {
        return $date?->format(self::DATE_FORMAT) ?? '';
    }
}
