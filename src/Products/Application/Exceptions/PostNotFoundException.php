<?php

namespace Src\Products\Application\Exceptions;

use Src\Products\Domain\Models\Post\Post;
use Src\Products\Domain\Models\Product\Product;

class PostNotFoundException extends \Exception
{
    public function __construct(Product $product, string $marketplaceSlug)
    {
        $productSku = $product->getSku();

        parent::__construct("Post em {$marketplaceSlug} para o produto {$productSku} não foi encontrado.");
    }
}
