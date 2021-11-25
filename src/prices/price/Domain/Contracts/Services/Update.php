<?php

namespace Src\Prices\Price\Domain\Contracts\Services;

use Src\Products\Domain\Models\Product\Contracts\Post;

interface Update
{
    public function execute(string $sku, Post $post): bool;
}
