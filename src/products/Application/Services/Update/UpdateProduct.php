<?php

namespace Src\Products\Application\Services\Update;

use App\Factories\Product\Dimensions;
use App\Factories\Product\Post;
use Src\Prices\Infrastructure\Repositories\Updator;
use Src\Products\Application\Services\Composition\GetProducts;
use Src\Products\Domain\Data\Compositions\Composition;
use Src\Products\Domain\Data\Dimensions as DimensionsObject;
use Src\Products\Domain\Entities\Product;
use Src\Products\Application\Services\Update\UpdatePosts;

class UpdateProduct
{
    private GetProducts $getCompositionProducts;
    private UpdatePosts $updatePosts;
    private Updator $productUpdator;

    public function __construct(GetProducts $getCompositionProducts, UpdatePosts $updatePosts, Updator $productUpdator)
    {
        $this->getCompositionProducts = $getCompositionProducts;
        $this->updatePosts = $updatePosts;
        $this->productUpdator = $productUpdator;
    }

    public function execute(Product $product, array $data): bool
    {
        $dimensions = $this->getDimensions($product, $data);
        $product->setDimensions($dimensions);

        $posts = $this->getPosts($product, $data['stores']);
        $product->setPosts($posts);

        $compositions = $this->getCompositionProducts($data);
        $product->setCompositionProducts($compositions);

        $product->setName($data['name']);
        $product->setActive($data['is_active']);
        $product->setBrand($data['brand']);

        return $this->productUpdator->update($product);
    }

    private function getCompositionProducts(array $data): Composition
    {
        return $this->getCompositionProducts->execute($data['composition_products']);
    }

    private function getDimensions(Product $product, array $data): DimensionsObject
    {
        return Dimensions::make($data, $product);
    }

    private function getPosts(Product $product, array $stores): array
    {
        foreach ($stores as $store) {
            if (!$post = $product->getPost($store['slug'])) {
                $post = Post::build($store);
            }

            $posts[]  = $post;
        }

        return $posts ?? [];
    }
}
