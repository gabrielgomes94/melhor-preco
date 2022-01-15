<?php

namespace Src\Products\Application\UseCases;

use Src\Products\Application\Services\ListProducts as ListProductsService;
use Src\Products\Domain\UseCases\Contracts\ListProducts as ListProductsInterface;
use Src\Products\Domain\Utils\Contracts\Options;

class ListProducts implements ListProductsInterface
{
    private ListProductsService $listProductsService;

    public function __construct(ListProductsService $listProductsService)
    {
        $this->listProductsService = $listProductsService;
    }

    public function list(Options $options): array
    {
        $paginator = $this->listProductsService->listPaginate($options);

        return [
            'paginator' => $paginator,
            'products' => $paginator->items(),
            'sku' => $options->sku(),
        ];
    }
}
