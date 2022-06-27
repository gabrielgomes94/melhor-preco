<?php

namespace Src\Prices\Domain\UseCases\Products;

use Src\Products\Domain\Models\Post\Contracts\Post;

interface UpdateCommand
{
    public function execute(string $sku, Post $post): bool;
}
