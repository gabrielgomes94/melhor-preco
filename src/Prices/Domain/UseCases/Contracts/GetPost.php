<?php

namespace Src\Prices\Domain\UseCases\Contracts;

use Src\Products\Domain\Exceptions\PostNotFoundException;
use Src\Products\Domain\Exceptions\ProductNotFoundException;
use Src\Products\Domain\Models\Post\Contracts\Post;

interface GetPost
{
    /**
     * @throws PostNotFoundException
     * @throws ProductNotFoundException
     */
    public function get(string $productId, string $marketplaceSlug, array $priceParameters): Post;
}
