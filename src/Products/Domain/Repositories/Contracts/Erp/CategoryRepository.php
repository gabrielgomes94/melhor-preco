<?php

namespace Src\Products\Domain\Repositories\Contracts\Erp;

interface CategoryRepository
{
    public function list(string $erpToken): array;
}
