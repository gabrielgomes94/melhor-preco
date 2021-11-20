<?php

namespace Src\Sales\Domain\UseCases\Contracts;

interface ListSales
{
    public function list(int $page): array;
}
