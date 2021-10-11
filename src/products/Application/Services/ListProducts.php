<?php

namespace Src\Products\Application\Services;

use Src\Products\Infrastructure\Repositories\ListDB;
use App\Services\Utils\Paginator;
use Src\Products\Domain\Contracts\Utils\Options;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListProducts
{
    private ListDB $repository;
    private Paginator $paginator;

    public function __construct(ListDB $repository, Paginator $paginator)
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
