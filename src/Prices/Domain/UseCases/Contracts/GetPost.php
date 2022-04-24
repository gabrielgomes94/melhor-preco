<?php

namespace Src\Prices\Domain\UseCases\Contracts;

use Src\Products\Application\Exceptions\PostNotFoundException;
use Src\Products\Application\Exceptions\ProductNotFoundException;
use Src\Products\Domain\Models\Product\Contracts\Post;

interface GetPost
{
    /**
     * @throws PostNotFoundException
     * @throws ProductNotFoundException
     */
    public function get(string $productId, string $marketplaceSlug, array $priceParameters): Post;
}
