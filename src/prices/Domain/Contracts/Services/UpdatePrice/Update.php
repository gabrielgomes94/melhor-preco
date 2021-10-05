<?php

namespace Src\Prices\Domain\Contracts\Services\UpdatePrice;

use Barrigudinha\Product\Entities\Post;

interface Update
{
    public function execute(string $sku, Post $post): bool;
}
