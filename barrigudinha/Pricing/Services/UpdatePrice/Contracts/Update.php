<?php

namespace Barrigudinha\Pricing\Services\UpdatePrice\Contracts;

use Barrigudinha\Product\Entities\Post;

interface Update
{
    public function execute(string $sku, Post $post): bool;
}
