<?php

namespace Src\Prices\Price\Domain\Contracts\Services;

use Src\Products\Domain\Entities\Post;

interface Update
{
    public function execute(string $sku, Post $post): bool;
}
