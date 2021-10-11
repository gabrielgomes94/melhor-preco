<?php

namespace Src\Prices\Domain\Contracts\Services\UpdatePrice;

use Src\Products\Domain\Entities\Post;

interface Update
{
    public function execute(string $sku, Post $post): bool;
}
