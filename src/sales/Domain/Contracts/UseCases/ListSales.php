<?php

namespace Src\Sales\Domain\Contracts\UseCases;

interface ListSales
{
    public function list(int $page): array;
}
