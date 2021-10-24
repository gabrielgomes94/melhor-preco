<?php

namespace Src\Prices\Price\Domain\Contracts\Services;

use Src\Products\Domain\Product\Contracts\Models\Post;

interface Update
{
    public function execute(string $sku, Post $post): bool;
}
