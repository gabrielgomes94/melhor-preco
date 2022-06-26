<?php

namespace Src\Prices\Domain\UseCases;

use Src\Products\Domain\Models\Post\Contracts\Post;

interface Update
{
    public function execute(string $sku, Post $post): bool;
}
