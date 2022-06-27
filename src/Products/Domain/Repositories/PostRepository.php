<?php

namespace Src\Products\Domain\Repositories;

use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Products\Domain\Models\Post\Post;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;

interface PostRepository
{
    public function get(Product $product, Marketplace $marketplace): ?Post;

    public function getByMarketplaceSlug(Product $product, string $marketplaceSlug): ?Post;
}
