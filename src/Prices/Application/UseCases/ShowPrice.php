<?php

namespace Src\Prices\Application\UseCases;

use Src\Prices\Domain\UseCases\Contracts\ShowPrice as ShowPriceInterface;
use Src\Products\Application\Exceptions\PostNotFoundException;
use Src\Products\Application\Exceptions\ProductNotFoundException;
use Src\Products\Domain\Models\Product\Product;

class ShowPrice implements ShowPriceInterface
{
    /**
     * @throws PostNotFoundException
     * @throws ProductNotFoundException
     */
    public function show(string $productId, string $storeSlug): array
    {
        if (!$product = Product::find($productId)) {
            throw new ProductNotFoundException($productId);
        }

        if (!$post = $product->getPost($storeSlug)) {
            throw new PostNotFoundException($product, $post);
        }

        return [
            'post' => $post,
            'product' => $product,
        ];
    }
}
