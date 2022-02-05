<?php

namespace Src\Products\Domain\Repositories\Contracts;

use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Products\Domain\Models\Post\Post;
use Src\Products\Domain\Models\Product\Product;

interface PostRepository
{
    public function get(Product $product, Marketplace $marketplace): ?Post;

    public function getByMarketplaceSlug(Product $product, string $marketplaceSlug): ?Post;
}
