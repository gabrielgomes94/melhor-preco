<?php

namespace Src\Products\Domain\DataTransfer;

use Illuminate\Contracts\Pagination\Paginator;

// @todo: mover para a camada de infraestrutura futuramente e criar interface para inverter as dependencias
class ProductsPaginated
{
    public function __construct(
        private Paginator $paginator
    )
    {
    }

    public function getPaginator(): Paginator
    {
        return $this->paginator;
    }

    public function getProducts(): array
    {
        return $this->paginator->items();
    }
}
