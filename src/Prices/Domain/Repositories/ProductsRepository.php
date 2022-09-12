<?php

namespace Src\Prices\Domain\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Src\Products\Infrastructure\Laravel\Repositories\Options\Options;

interface ProductsRepository
{
    public function list(Options $options): LengthAwarePaginator;
}
