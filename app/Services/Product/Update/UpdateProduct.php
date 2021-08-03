<?php

namespace App\Services\Product\Update;

use App\Factories\Product\Dimensions;
use App\Factories\Product\Post;
use App\Repositories\Product\Updator;
use Barrigudinha\Product\Data\Dimensions as DimensionsObject;
use Barrigudinha\Product\Product;

class UpdateProduct
{
    private UpdatePosts $updatePosts;
    private Updator $productUpdator;

    public function __construct(UpdatePosts $updatePosts, Updator $productUpdator)
    {
        $this->updatePosts = $updatePosts;
        $this->productUpdator = $productUpdator;
    }

    public function execute(Product $product, array $data): bool
    {
        $product->setDimensions($this->getDimensions($product, $data));
        $product->setName($data['name']);

        $posts = $this->setPosts($product, $data['stores']);
        $product->setPosts($posts);
        $product->setCompositionProducts($data['composition_products']);

        return $this->productUpdator->update($product);
    }

    private function getDimensions(Product $product, array $data): DimensionsObject
    {
        return Dimensions::make($data, $product);
    }

    private function setPosts(Product $product, array $stores): array
    {
        foreach ($stores as $store) {
            if (!$post = $product->getPost($store['slug'])) {
                $post = Post::build($store);
            }

            $this->updatePosts->updatePrice($product, $post->store(), $store['price']);
            $posts[]  = $post;
        }

        return $posts ?? [];
    }
}
