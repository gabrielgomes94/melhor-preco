<?php

namespace Src\Products\Domain\Models\Post\Contracts;

use Src\Prices\Infrastructure\Laravel\Models\Price as PriceModel;
use Src\Products\Domain\Models\Post\Post;

interface Factory
{
    public function make(PriceModel $priceModel): Post;
}
