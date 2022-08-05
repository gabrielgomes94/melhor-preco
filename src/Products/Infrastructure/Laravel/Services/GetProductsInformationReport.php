<?php

namespace Src\Products\Infrastructure\Laravel\Services;

use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Products\Domain\DataTransfer\FilterOptions;
use Src\Products\Domain\Models\Product\Product;
use Src\Products\Domain\Repositories\ProductRepository;
use Src\Sales\Domain\Repositories\SaleItemsRepository;
use Src\Users\Domain\Entities\User;


class GetProductsInformationReport
{
    public function __construct(
        private ProductRepository $productRepository,
        private SaleItemsRepository $saleItemsRepository
    ) {
    }

    public function report(FilterOptions $filter, User $user): array
    {
        $productsPaginator = $this->getProducts($filter, $user);

        $products = collect($productsPaginator->items());
        $products = $products->map(function (Product $product) {
            return [
                'sku' => $product->getIdentifiers()->getSku(),
                'name' => $product->getDetails()->getName(),
                'imagesCount' => count($product->getImages()),
                'sales' => $this->saleItemsRepository->countSalesByProduct(
                    $product,
                    $filter->beginDate ?? Carbon::createFromFormat('d/m/Y', '01/01/2001'),
                    $filter->endDate ?? Carbon::now()
                ),
            ];
        })->toArray();

        return [
            'data' => $products,
            'paginator' => $productsPaginator,
        ];
    }

    private function getProducts(FilterOptions $filter, User $user): LengthAwarePaginator
    {
        return $this->productRepository->allFiltered($filter, $user->getId());
    }
}
