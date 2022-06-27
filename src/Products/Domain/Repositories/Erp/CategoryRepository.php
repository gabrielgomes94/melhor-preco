<?php

namespace Src\Products\Domain\Repositories\Erp;

interface CategoryRepository
{
    public function list(string $erpToken): array;
}
