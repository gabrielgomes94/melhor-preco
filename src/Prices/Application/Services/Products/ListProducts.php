<?php

namespace Src\Prices\Application\Services\Products;

use Src\Products\Domain\Repositories\Contracts\ProductWithPriceRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Src\Products\Infrastructure\Laravel\Repositories\Options\Options;

class ListProducts
{
    private ProductWithPriceRepository $repository;

    public function __construct(ProductWithPriceRepository $repository)
    {
        $this->repository = $repository;
    }
    public function listPaginate(Options $options): LengthAwarePaginator
    {
        $page = $options->page();
        $store = $options->store();

        if ($options->hasCategories()) {
            return $this->repository->listProductsByCategory(
                $store,
                $options->getCategoryId(),
                $page
            );
        }

        if ($options->sku()) {
            return $this->repository->listProductsBySku(
                $store,
                $options->sku(),
                $page
            );
        }

        if ($options->shouldFilterKits()) {
            return $this->repository->listCompositionProducts(
                $store,
                $page
            );
        }

        return $this->repository->listProducts($store, $page);
    }
}
