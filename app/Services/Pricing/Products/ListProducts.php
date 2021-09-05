<?php

namespace App\Services\Pricing\Products;

use App\Repositories\Pricing\Product\ListDB;
use App\Services\Utils\Paginator;
use Barrigudinha\Product\Utils\Contracts\Options;
use Illuminate\Pagination\LengthAwarePaginator;

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
