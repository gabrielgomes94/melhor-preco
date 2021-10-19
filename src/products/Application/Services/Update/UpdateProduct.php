<?php

namespace Src\Products\Application\Services\Update;

use Src\Prices\Calculator\Domain\Services\V1\CalculateProduct;
use Src\Products\Application\Factories\Dimensions;
use Src\Products\Application\Factories\Post;
use Src\Products\Infrastructure\Repositories\Updator;
use Src\Products\Application\Services\Composition\GetProducts;
use Src\Products\Domain\Data\Compositions\Composition;
use Src\Products\Domain\Data\Dimensions as DimensionsObject;
use Src\Products\Domain\Entities\Product;

class UpdateProduct
{
    private GetProducts $getCompositionProducts;
    private UpdatePosts $updatePosts;
    private Updator $productUpdator;
    private CalculateProduct $calculateProductService;

    public function __construct(GetProducts $getCompositionProducts, UpdatePosts $updatePosts, Updator $productUpdator, CalculateProduct $calculateProductService)
    {
        $this->getCompositionProducts = $getCompositionProducts;
        $this->updatePosts = $updatePosts;
        $this->productUpdator = $productUpdator;
        $this->calculateProductService = $calculateProductService;
    }

    public function execute(Product $product, array $data): bool
    {
        $dimensions = $this->getDimensions($product, $data);
        $product->setDimensions($dimensions);

        $posts = $this->getPosts($product, $data['stores']);
        $product->setPosts($posts);

        $product = $this->calculateProductService->recalculate($product);

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
