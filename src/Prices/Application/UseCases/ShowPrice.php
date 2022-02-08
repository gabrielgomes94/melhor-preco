<?php

namespace Src\Prices\Application\UseCases;

use Src\Prices\Domain\UseCases\Contracts\ShowPrice as ShowPriceInterface;
use Src\Products\Application\Exceptions\PostNotFoundException;
use Src\Products\Application\Exceptions\ProductNotFoundException;
use Src\Products\Domain\Models\Product\Product;
use Src\Products\Domain\Repositories\Contracts\PostRepository;

class ShowPrice implements ShowPriceInterface
{
    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * @throws PostNotFoundException
     * @throws ProductNotFoundException
     */
    public function show(string $productId, string $marketplaceSlug): array
    {
        if (!$product = Product::find($productId)) {
            throw new ProductNotFoundException($productId);
        }

        if (!$post = $this->postRepository->getByMarketplaceSlug($product, $marketplaceSlug)) {
            throw new PostNotFoundException($product, $marketplaceSlug);
        }

        return [
            'post' => $post,
            'product' => $product,
        ];
    }
}
