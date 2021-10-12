<?php

namespace Src\Products\Domain\Contracts\Repositories;

use Src\Products\Domain\Entities\ProductsCollection;
use Src\Products\Domain\Contracts\Utils\Options;

interface ListProducts
{
    public function all(): ProductsCollection;

    public function count(Options $options): int;

    public function list(Options $options): ProductsCollection;
}
