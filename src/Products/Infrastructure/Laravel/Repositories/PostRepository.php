<?php

namespace Src\Products\Infrastructure\Laravel\Repositories;

use Src\Marketplaces\Application\Models\Marketplace;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Products\Domain\Models\Post\Factories\Factory as PostFactory;
use Src\Products\Domain\Models\Post\Post;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;
use Src\Products\Domain\Repositories\Contracts\PostRepository as PostRepositoryInterface;

class PostRepository implements PostRepositoryInterface
{
    private MarketplaceRepository $marketplaceRepository;
    private PostFactory $factory;

    public function __construct(MarketplaceRepository $marketplaceRepository, PostFactory $factory)
    {
        $this->marketplaceRepository = $marketplaceRepository;
        $this->factory = $factory;
    }

    public function get(Product $product, Marketplace $marketplace): ?Post
    {
        $posts = $this->getPosts($product);

        foreach ($posts as $post) {
            if ($this->isPostInMarketplace($post, $marketplace)) {
                return $post;
            }
        }

        return null;
    }

    public function getByMarketplaceSlug(Product $product, string $marketplaceSlug): ?Post
    {
        $marketplace = $this->marketplaceRepository->getBySlug($marketplaceSlug);

        return $this->get($product, $marketplace);
    }

    private function getPosts(Product $product): array
    {
        foreach ($product->getPrices() as $price) {
            $posts[] = $this->factory->make($price);
        }

        return $posts ?? [];
    }

    private function isPostInMarketplace(Post $post, Marketplace $marketplace): bool
    {
        return $post->getMarketplace()->getSlug() === $marketplace->getSlug();
    }
}
