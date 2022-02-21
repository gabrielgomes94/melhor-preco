<?php

namespace Src\Calculator\Application\Services;

use Src\Calculator\Domain\Services\Contracts\SimulatePost;
use Src\Calculator\Domain\Models\Product\ProductData;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Products\Application\Exceptions\ProductNotFoundException;
use Src\Products\Domain\Models\Product\Contracts\Post;
use Src\Products\Domain\Models\Product\Product;
use Src\Products\Domain\Models\Post\Factories\Factory as PostFactory;
use Src\Products\Domain\Repositories\Contracts\PostRepository;

class SimulatePostService implements SimulatePost
{
    private CalculatePrice $calculatePrice;
    private MarketplaceRepository $marketplaceRepository;
    private PostFactory $postFactory;
    private PostRepository $postRepository;

    public function __construct(
        CalculatePrice $calculatePrice,
        MarketplaceRepository $marketplaceRepository,
        PostFactory $postFactory,
        PostRepository $postRepository
    ) {
        $this->calculatePrice = $calculatePrice;
        $this->marketplaceRepository = $marketplaceRepository;
        $this->postFactory = $postFactory;
        $this->postRepository = $postRepository;
    }

    public function calculate(array $data): Post
    {
        // @todo: usar o repositório aqui para pegar os produtos
        if (!$product = Product::find($data['productId'])) {
            throw new ProductNotFoundException($data['productId']);
        }

        $marketplace = $this->marketplaceRepository->getBySlug($data['storeSlug']);

        $price = $this->calculatePrice->calculate(
            ProductData::fromModel($product),
            $marketplace,
            $data['price'],
            $data['commission'],
            $data['options']
        );

        $post = $this->postRepository->getByMarketplaceSlug($product, $data['storeSlug']);

        return $this->postFactory->updatePrice($post, $price);
    }
}
