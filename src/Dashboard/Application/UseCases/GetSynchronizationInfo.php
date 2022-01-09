<?php

namespace Src\Dashboard\Application\UseCases;

use Src\Costs\Domain\Repositories\DbRepository;
use Src\Dashboard\Domain\UseCases\GetSynchronizationInfo as GetSynchronizationInfoInterface;
use Src\Products\Domain\Repositories\Contracts\ProductRepository;
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
        $syncedProducts = $this->repository->count();
        $activeProducts = $this->repository->countActives();
        $lastUpdatedAt = $this->repository->getLastSynchronizationDateTime()->format(self::DATE_FORMAT);

        $syncedInvoicesQuantity = $this->costsRepository->countPurchaseInvoices();
        $lastUpdatedInvoices = $this->costsRepository->getLastSynchronizationDateTime()->format(self::DATE_FORMAT);

        $syncedSalesQuantity = $this->salesRepository->countSales();
        $lastUpdatedSales = $this->salesRepository->getLastSaleDateTime()->format(self::DATE_FORMAT);

        return [
            'products' => [
                'syncedQuantity' => $syncedProducts,
                'activeQuantity' => $activeProducts,
                'lastUpdatedAt' => $lastUpdatedAt,
            ],
            'invoices' => [
                'syncedQuantity' => $syncedInvoicesQuantity,
                'lastUpdatedAt' => $lastUpdatedInvoices,
            ],
            'sales' => [
                'syncedQuantity' => $syncedSalesQuantity,
                'lastUpdatedAt' => $lastUpdatedSales,
            ],
        ];
    }
}
