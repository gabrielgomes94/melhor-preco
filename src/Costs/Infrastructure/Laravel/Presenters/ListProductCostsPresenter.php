<?php

namespace Src\Costs\Infrastructure\Laravel\Presenters;

use Src\Products\Application\Data\FilterOptions;
use Src\Products\Domain\DataTransfer\ProductsPaginated;

class ListProductCostsPresenter
{
    public static function present(ProductsPaginated $data, FilterOptions $options): array
    {
        return [
            'products' => $data->getProducts(),
            'paginator' => $data->getPaginator(),
            'filter' => [
                'sku' => $options->sku
            ]
        ];
    }
}
