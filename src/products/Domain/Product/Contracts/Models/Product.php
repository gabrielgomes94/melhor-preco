<?php

namespace Src\Products\Domain\Product\Contracts\Models;

use Src\Products\Domain\Product\Contracts\Models\Data\Product as ProductData;

interface Product
{
    public function data(): ProductData;
}
