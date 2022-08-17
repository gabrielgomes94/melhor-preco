<?php

namespace Src\Costs\Infrastructure\Laravel\Repositories;

use Src\Products\Domain\DataTransfer\FilterOptions;
use Src\Products\Domain\DataTransfer\ProductsPaginated;
use Src\Products\Infrastructure\Laravel\Repositories\ProductRepository;

/**
 * @deprecated Check if this service is really necessary. maybe the repository could return ProductsPaginated instance
 * @todo: Remover essa classe que não serve pra nada. Refatorar a busca pelos produtos e a exibição deles na tela de custos
 */
class ListProducts
{
    public function __construct(
        private ProductRepository $productRepository
    ) {
    }

    public function list(FilterOptions $options, string $userId): ProductsPaginated
    {
        $paginator = $this->productRepository->allFiltered($options, $userId);

        return new ProductsPaginated($paginator);
    }
}
