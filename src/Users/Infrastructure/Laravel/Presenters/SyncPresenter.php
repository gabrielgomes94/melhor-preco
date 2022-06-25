<?php

namespace Src\Users\Infrastructure\Laravel\Presenters;

use Src\Costs\Infrastructure\Laravel\Repositories\Repository as CostsRepository;
use Src\Prices\Infrastructure\Laravel\Repositories\Repository as PriceRepository;
use Src\Products\Domain\Repositories\CategoryRepository;
use Src\Products\Infrastructure\Laravel\Repositories\ProductRepository;
use Src\Sales\Domain\Repositories\Contracts\Repository as SalesRepository;

class SyncPresenter
{
    public function __construct(
        private CostsRepository $costsRepository,
        private CategoryRepository $categoryRepository,
        private ProductRepository $productRepository,
        private SalesRepository $salesRepository,
        private PriceRepository $priceRepository
    ) {
    }

    public function present(): array
    {
        return [
            'categories' => [
                'quantity' => $this->categoryRepository->count(),
                'syncedAt' => $this->categoryRepository->getLastUpdatedAt()?->format('d/m/Y H:i'),
                'route' => 'categories.sync',
            ],
            'prices' => [
                'quantity' => $this->priceRepository->count(),
                'syncedAt' => $this->priceRepository->getLastSynchronizationDateTime()?->format('d/m/Y H:i'),
                'route' => 'pricing.syncAll',
            ],
            'products' => [
                'quantity' => $this->productRepository->count(),
                'syncedAt' => $this->productRepository->getLastSynchronizationDateTime()?->format('d/m/Y H:i'),
                'route' => 'products.sync',
            ],
            'purchaseInvoices' => [
                'quantity' => $this->costsRepository->countPurchaseInvoices(),
                'syncedAt' => $this->costsRepository->getLastSynchronizationDateTime()?->format('d/m/Y H:i'),
                'route' => 'costs.sync',
            ],
            'sales' => [
                'quantity' => $this->salesRepository->countSales(),
                'syncedAt' => $this->salesRepository->getLastSaleDateTime()?->format('d/m/Y H:i'),
                'route' => 'sales.sync',
            ],
        ];
    }
}
