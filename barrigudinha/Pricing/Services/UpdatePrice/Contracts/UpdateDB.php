<?php

namespace Barrigudinha\Pricing\Services\UpdatePrice\Contracts;

use Barrigudinha\Product\Entities\Post;

interface UpdateDB
{
    public function execute(Post $post): bool;
}
