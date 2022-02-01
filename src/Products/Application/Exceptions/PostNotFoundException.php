<?php

namespace Src\Products\Application\Exceptions;

use Src\Products\Domain\Models\Post\Post;
use Src\Products\Domain\Models\Product\Product;

class PostNotFoundException extends \Exception
{
    public function __construct(Product $product, Post $post)
    {
        $productSku = $product->getSku();
        $storeName = $post->getMarketplace()->getName();

        parent::__construct("Post em {$storeName} para o produto {$productSku} não foi encontrado.");
    }
}
