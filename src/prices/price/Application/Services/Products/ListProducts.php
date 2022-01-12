<?php

namespace Src\Prices\Price\Application\Services\Products;

use Src\Products\Domain\Repositories\Contracts\ProductRepository;
use Src\Products\Domain\Utils\Contracts\Options;
use Illuminate\Pagination\LengthAwarePaginator;
use Src\Products\Domain\Models\Product\Product;

class ListProducts
{
    private ProductRepository $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }
    public function listPaginate(Options $options): LengthAwarePaginator
    {
        $page = $options->page();
        $store = $options->store();

        if ($options->sku()) {
            return $this->repository->listProductsBySku(
                $store,
                $options->sku(),
                $page
            );
        }

        if ($options->shouldFilterKits()) {
            return Product::listCompositionProducts(
                $store,
                $page
            );
        }

        return $this->repository->listProducts($store, $page);
    }
}
