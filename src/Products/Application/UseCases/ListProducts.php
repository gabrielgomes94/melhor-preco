<?php

namespace Src\Products\Application\UseCases;

use Src\Products\Application\Data\FilterOptions;
use Src\Products\Domain\DataTransfer\ProductsPaginated;
use Src\Products\Domain\UseCases\Contracts\ListProducts as ListProductsInterface;
use Src\Products\Infrastructure\Laravel\Repositories\ProductRepository;

class ListProducts implements ListProductsInterface
{
    public function __construct(
        private ProductRepository $productRepository
    ) {
    }

    public function list(FilterOptions $options): ProductsPaginated
    {
        $paginator = $this->productRepository->allFiltered($options);

        return new ProductsPaginated($paginator);
    }
}
