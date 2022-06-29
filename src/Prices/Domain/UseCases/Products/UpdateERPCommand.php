<?php

namespace Src\Prices\Domain\UseCases\Products;

use Src\Products\Domain\Models\Post\Post;

interface UpdateERPCommand
{
    public function execute(string $erpToken, string $sku, Post $post): bool;
}
