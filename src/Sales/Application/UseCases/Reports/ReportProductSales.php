<?php

namespace Src\Sales\Application\UseCases\Reports;

use Illuminate\Support\Collection;
use Src\Products\Application\Exceptions\ProductNotFoundException;
use Src\Products\Domain\Models\Product\Product;
use Src\Products\Domain\Repositories\Contracts\ProductRepository;
use Src\Sales\Domain\Models\Item;

class ReportProductSales
{
    private ProductRepository $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function report(string $sku): array
    {
        $product = $this->repository->get($sku);

        if (!$product) {
            throw new ProductNotFoundException();
        }

        $sales = $product->items;

        $b2wSales = $this->filterSalesFromStore($sales, 'b2w');
        $magaluSales = $this->filterSalesFromStore($sales, 'magalu');
        $mercadoLivreSales = $this->filterSalesFromStore($sales, 'mercado_livre');
        $olistSales = $this->filterSalesFromStore($sales, 'olist');
        $shopeeSales = $this->filterSalesFromStore($sales, 'shopee');
        $internalSales = $this->filterSalesFromStore($sales, 'barrigudinha');

        return [
            'total' => [
                'quantity' => $sales->count(),
                'value' => $sales->sum(function(Item $saleItem) {
                    return $saleItem->getTotalValue();
                }),
            ],
            'stores' => [
                [
                    'quantity' => $b2wSales->count(),
                    'value' => $b2wSales->sum(function(Item $saleItem) {
                        return $saleItem->getTotalValue();
                    }),
                    'slug' => 'b2w',
                    'storeName' => 'B2W',
                ],
                [
                    'quantity' => $magaluSales->count(),
                    'value' => $magaluSales->sum(function(Item $saleItem) {
                        return $saleItem->getTotalValue();
                    }),
                    'slug' => 'magalu',
                    'storeName' => 'Magalu',
                ],
                [
                    'quantity' => $mercadoLivreSales->count(),
                    'value' => $mercadoLivreSales->sum(function(Item $saleItem) {
                        return $saleItem->getTotalValue();
                    }),
                    'slug' => 'mercado_livre',
                    'storeName' => 'Mercado Livre',
                ],
                [
                    'quantity' => $olistSales->count(),
                    'value' => $olistSales->sum(function(Item $saleItem) {
                        return $saleItem->getTotalValue();
                    }),
                    'slug' => 'olist',
                    'storeName' => 'Olist',
                ],
                [
                    'quantity' => $shopeeSales->count(),
                    'value' => $shopeeSales->sum(function(Item $saleItem) {
                        return $saleItem->getTotalValue();
                    }),
                    'slug' => 'shopee',
                    'storeName' => 'Shopee',
                ],
                [
                    'quantity' => $internalSales->count(),
                    'value' => $internalSales->sum(function(Item $saleItem) {
                        return $saleItem->getTotalValue();
                    }),
                    'slug' => 'barrigudinha',
                    'storeName' => 'Loja Física',
                ]
            ],
        ];
    }

    private function filterSalesFromStore(Collection $sales, string $storeSlug)
    {
        return $sales->filter(function(Item $saleItem) use ($storeSlug) {
            $saleOrder = $saleItem->saleOrder;

            if (!$saleOrder) {
                return false;
            }

            $slug = $saleItem->saleOrder?->getMarketplace()?->getSlug() ?? '';
            return $slug === $storeSlug;
        });
    }
}

