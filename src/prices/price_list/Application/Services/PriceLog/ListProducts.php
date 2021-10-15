<?php

namespace Src\Prices\PriceList\Application\Services\PriceLog;

use Src\Prices\PriceList\Infrastructure\Repositories\PriceLog\ListDB;
use App\Services\Utils\Paginator;
use Src\Products\Domain\Contracts\Utils\Options;
use Illuminate\Pagination\LengthAwarePaginator;

class ListProducts
{
    private \Src\Prices\PriceList\Infrastructure\Repositories\PriceLog\ListDB $repository;
    private Paginator $paginator;

    public function __construct(\Src\Prices\PriceList\Infrastructure\Repositories\PriceLog\ListDB $repository, Paginator $paginator)
    {
        $this->repository = $repository;
        $this->paginator = $paginator;
    }

    public function listPaginate(Options $options): LengthAwarePaginator
    {
        $products = $this->repository->list($options);

        return $this->paginator->paginate(
            array: $products,
            options: $options,
            count: $this->repository->count($options)
        );
    }
}
