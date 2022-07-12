<?php

namespace Src\Users\Infrastructure\Laravel\Presenters;

use Src\Costs\Infrastructure\Laravel\Repositories\Repository as CostsRepository;
use Src\Prices\Infrastructure\Laravel\Repositories\PriceRepository as PriceRepository;
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
        private PriceRepository $priceRepository
    ) {
    }

    public function present(string $userId): array
    {
        return [
            'categories' => [
                'quantity' => $this->categoryRepository->count($userId),
                'syncedAt' => $this->categoryRepository->getLastUpdatedAt($userId)?->format('d/m/Y H:i'),
                'route' => 'categories.sync',
            ],
            'prices' => [
                'quantity' => $this->priceRepository->count($userId),
                'syncedAt' => $this->priceRepository->getLastSynchronizationDateTime($userId)?->format('d/m/Y H:i'),
                'route' => 'pricing.syncAll',
            ],
            'products' => [
                'quantity' => $this->productRepository->count($userId),
                'syncedAt' => $this->productRepository->getLastSynchronizationDateTime($userId)?->format('d/m/Y H:i'),
                'route' => 'products.sync',
            ],
            'purchaseInvoices' => [
                'quantity' => $this->costsRepository->countPurchaseInvoices(),
                'syncedAt' => $this->costsRepository->getLastSynchronizationDateTime()?->format('d/m/Y H:i'),
                'route' => 'costs.sync',
            ],
            'sales' => [
                'quantity' => $this->salesRepository->countSales(new SalesFilter(['userId' => $userId])),
                'syncedAt' => $this->salesRepository->getLastSaleDateTime($userId)?->format('d/m/Y H:i'),
                'route' => 'sales.sync',
            ],
        ];
    }
}
