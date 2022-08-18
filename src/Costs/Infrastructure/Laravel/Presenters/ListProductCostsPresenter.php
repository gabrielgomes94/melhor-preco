<?php

namespace Src\Costs\Infrastructure\Laravel\Presenters;

use Illuminate\Contracts\Pagination\Paginator;
use Src\Products\Domain\DataTransfer\FilterOptions;

class ListProductCostsPresenter
{
    public static function present(Paginator $paginator, FilterOptions $options): array
    {
        return [
            'products' => $paginator->items(),
            'paginator' => $paginator,
            'filter' => [
                'sku' => $options->sku
            ]
        ];
    }
}
