<?php

namespace App\Services\Product\Update;

use App\Factories\Product\Dimensions;
use App\Factories\Product\Post;
use App\Repositories\Product\DB\Updator;
use App\Repositories\Store\Store as StoreRepository;
use Barrigudinha\Pricing\Price\Services\CalculatePrice;
use Barrigudinha\Product\Product;
use Barrigudinha\Utils\Helpers;

class UpdateProduct
{
    private CalculatePrice $calculatePrice;
    private UpdatePosts $updatePosts;
    private Updator $productUpdator;
    private StoreRepository $storeRepository;

    public function __construct(CalculatePrice $calculatePrice, UpdatePosts $updatePosts, Updator $productUpdator, StoreRepository $storeRepository)
    {
        $this->calculatePrice = $calculatePrice;
        $this->updatePosts = $updatePosts;
        $this->productUpdator = $productUpdator;
        $this->storeRepository = $storeRepository;
    }

    public function execute(Product $product, array $data): bool
    {
        $product->setDimensions($this->getDimensions($product, $data));
        $product->setName($data['name']);
        $product->setPosts($this->getPosts($product, $data['stores']));

        return $this->productUpdator->update($product);
    }

    private function getDimensions(Product $product, array $data)
    {
        return Dimensions::make([
            'depth' => $data['depth'],
            'height' => $data['height'],
            'width' => $data['width'],
        ], $product);
    }

    private function getPosts(Product $product, array $stores): array
    {
        foreach ($stores as $store) {
            if (!$post = $product->getPost($store['slug'])) {
                $posts[] = Post::build($store);
            }

            $this->updatePosts->updatePrice($product, $post->store(), $store['price']);
            $posts[]  = $post;
        }

        return $posts ?? [];
    }
}
