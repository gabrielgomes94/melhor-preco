<?php

namespace Src\Prices\Domain\Contracts\Services\UpdatePrice;

use Barrigudinha\Product\Entities\Post;

interface UpdateDB
{
    public function execute(Post $post): bool;
}
