<?php

namespace Src\Prices\Application\UseCases;

use Src\Calculator\Domain\UseCases\Contracts\CalculatePrice;
use Src\Prices\Domain\UseCases\Contracts\GetPost as GetPostInterface;
use Src\Products\Domain\Exceptions\PostNotFoundException;
use Src\Products\Domain\Exceptions\ProductNotFoundException;
use Src\Products\Domain\Models\Post\Contracts\Post;
use Src\Products\Domain\Models\Product\Product;
use Src\Products\Infrastructure\Laravel\Models\Product\Product as ProductModel;
use Src\Products\Domain\Repositories\PostRepository;

class GetPost implements GetPostInterface
{
    public function __construct(
        private PostRepository $postRepository,
        private CalculatePrice $calculatePriceUseCase
    ) {
    }

    /**
     * @throws PostNotFoundException
     * @throws ProductNotFoundException
     */
    public function get(string $productId, string $marketplaceSlug, array $priceParameters): Post
    {
        if (!$product = ProductModel::find($productId)) {
            throw new ProductNotFoundException($productId);
        }

        if (empty($priceParameters)) {
            return $this->getPost($product, $marketplaceSlug);
        }

        return $this->calculatePriceUseCase->calculate($priceParameters);
    }

    /**
     * @throws PostNotFoundException
     */
    private function getPost(Product $product, string $marketplaceSlug): Post
    {
        if (!$post = $this->postRepository->getByMarketplaceSlug($product, $marketplaceSlug)) {
            throw new PostNotFoundException($product, $marketplaceSlug);
        }

        return $this->calculatePriceUseCase->calculate([
            'productId' => $product->getSku(),
            'storeSlug' => $marketplaceSlug,
            'price' => $post->getPrice()->getValue(),
            'commission' => $post->getPrice()->getCommission(),
            'options' => [
//                    CalculatorOptions::FREE_FREIGHT => $this->hasFreeFreight(),
            ]
        ]);
    }
}
