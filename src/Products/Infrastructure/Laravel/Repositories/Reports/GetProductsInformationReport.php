<?php

namespace Src\Products\Infrastructure\Laravel\Repositories\Reports;

use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Src\Products\Domain\DataTransfer\FilterOptions;
use Src\Products\Domain\Models\Product;
use Src\Products\Domain\Repositories\ProductRepository;
use Src\Sales\Application\Repositories\ProductSalesRepository;
use Src\Users\Domain\Models\User;

class GetProductsInformationReport
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly ProductSalesRepository $productSalesRepository
    ) {
    }

    public function report(FilterOptions $filter, User $user): array
    {
        $productsPaginator = $this->getProducts($filter, $user);

        $products = collect($productsPaginator->items());
        $products = $products->map(function (Product $product) {
            return [
                'sku' => $product->getSku(),
                'name' => $product->getName(),
                'imagesCount' => count($product->getImages()),
                'sales' => $this->productSalesRepository->count(
                    $product,
                    $filter->beginDate ?? Carbon::createFromFormat('d/m/Y', '01/01/2001'),
                    $filter->endDate ?? Carbon::now()
                ),
            ];
        })->sortBy('name')->toArray();

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
