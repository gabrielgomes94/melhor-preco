<?php

namespace Barrigudinha\Pricing\Services\UpdatePrice\Contracts;

use Barrigudinha\Product\Entities\Post;

interface UpdateERP
{
    public function execute(string $sku, Post $post): bool;
}
