<?php

namespace Src\Users\Infrastructure\Laravel\UseCases;

use Carbon\Carbon;
use Src\Costs\Domain\Repositories\DbRepository;
use Src\Sales\Domain\DataTransfer\SalesFilter;
use Src\Sales\Domain\Repositories\SaleOrderRepository;
use Src\Users\Domain\UseCases\GetSynchronizationInfo as GetSynchronizationInfoInterface;
use Src\Products\Domain\Repositories\ProductRepository;

class GetSynchronizationInfo implements GetSynchronizationInfoInterface
{
    private const DATE_FORMAT = 'd-m-Y H:i:s';

    public function __construct(
        private readonly ProductRepository $repository,
        private readonly DbRepository $costsRepository,
        private readonly SaleOrderRepository $salesRepository
    ) {
    }

    public function get(string $userId): array
    {
        return [
            'products' => [
                'syncedQuantity' => $this->repository->count($userId),
                'activeQuantity' => $this->repository->countActives($userId),
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
                'syncedQuantity' => $this->salesRepository->countSales(
                    new SalesFilter([
                        'userId' => $userId,
                    ])
                ),
                'lastUpdatedAt' => $this->formatDate(
                    $this->salesRepository->getLastSaleDateTime($userId)
                ),
            ],
        ];
    }

    private function formatDate(?Carbon $date): string
    {
        return $date?->format(self::DATE_FORMAT) ?? '';
    }
}
