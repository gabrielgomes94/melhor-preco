<?php

namespace Src\Users\Infrastructure\Laravel\Presenters;

use Src\Costs\Infrastructure\Laravel\Repositories\Repository as CostsRepository;
use Src\Prices\Infrastructure\Laravel\Repositories\PricesRepository;
use Src\Products\Domain\Repositories\CategoryRepository;
use Src\Products\Infrastructure\Laravel\Repositories\ProductRepository;
use Src\Sales\Domain\DataTransfer\SalesFilter;
use Src\Sales\Domain\Repositories\SaleOrderRepository;

class SyncPresenter
{
    public function __construct(
        private CostsRepository $costsRepository,
        private CategoryRepository $categoryRepository,
        private ProductRepository $productRepository,
        private SaleOrderRepository $salesRepository,
        private PricesRepository $priceRepository
    ) {
    }

    public function present(string $userId): array
    {
        return [
            'categories' => [
                'quantity' => $this->categoryRepository->count($userId),
                'syncedAt' => $this->categoryRepository->getLastUpdatedAt($userId)?->format('d/m/Y H:i'),
            ],
            'prices' => [
                'quantity' => $this->priceRepository->count($userId),
                'syncedAt' => $this->priceRepository->getLastSynchronizationDateTime($userId)?->format('d/m/Y H:i'),
            ],
            'products' => [
                'quantity' => $this->productRepository->count($userId),
                'syncedAt' => $this->productRepository->getLastSynchronizationDateTime($userId)?->format('d/m/Y H:i'),
            ],
            'purchaseInvoices' => [
                'quantity' => $this->costsRepository->countPurchaseInvoices($userId),
                'syncedAt' => $this->costsRepository->getLastSynchronizationDateTime($userId)?->format('d/m/Y H:i'),
            ],
            'sales' => [
                'quantity' => $this->salesRepository->countSales($userId),
                'syncedAt' => $this->salesRepository->getLastSaleDateTime($userId)?->format('d/m/Y H:i'),
            ],
        ];
    }
}
