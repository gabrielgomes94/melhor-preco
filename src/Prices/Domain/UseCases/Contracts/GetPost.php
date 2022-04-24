<?php

namespace Src\Prices\Domain\UseCases\Contracts;

use Src\Products\Domain\Models\Product\Contracts\Post;

interface GetPost
{
    public function show(string $productId, string $marketplaceSlug, array $priceParameters): Post;
}
