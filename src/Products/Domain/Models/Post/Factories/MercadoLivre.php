<?php

namespace Src\Products\Domain\Models\Post\Factories;

use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Math\Percentage;
use Src\Math\MoneyTransformer;
use Src\Calculator\Domain\Models\Price\Price;
use Src\Calculator\Domain\Models\Product\ProductData;
use Src\Calculator\Application\Services\CalculatePost;
use Src\Calculator\Application\Services\CalculatePrice;
use Src\Products\Domain\Models\Categories\Category;
use Src\Products\Domain\Models\Post\Contracts\Factory as FactoryInterface;
use Src\Products\Domain\Models\Post\Identifiers\Identifiers as PostIdentifiers;
use Src\Products\Domain\Models\Post\MercadoLivrePost;
use Src\Products\Domain\Models\Post\Post;
use Src\Products\Domain\Models\Product\Data\Costs\Costs;
use Src\Products\Domain\Models\Product\Data\Dimensions\Dimensions;

class MercadoLivre implements FactoryInterface
{
    private CalculatePrice $calculatePriceService;
    private CalculatePost $calculatePostService;
    private MarketplaceRepository $marketplaceRepository;

    public function __construct(CalculatePrice $calculatePriceService, CalculatePost $calculatePostService, MarketplaceRepository $marketplaceRepository)
    {
        $this->calculatePriceService = $calculatePriceService;
        $this->calculatePostService = $calculatePostService;
        $this->marketplaceRepository = $marketplaceRepository;
    }

    public function make(array $data): Post
    {
        $marketplace = $this->marketplaceRepository->getBySlug($data['store']);

        $post = new MercadoLivrePost(
            identifiers: new PostIdentifiers($data['id'], $data['store_sku_id']),
            marketplace: $marketplace,
            price: $this->calculatePostService->calculate($data)
        );

        $secondaryPrice = self::getSecondaryPrice($post, $data['costs'], $data['dimensions'], $data['category']);
        $post->setSecondaryPrice($secondaryPrice);

        return $post;
    }

    public function updatePrice(Post $post, Price $price, Costs $costs, Dimensions $dimensions, Category $category): Post
    {
        $post = new MercadoLivrePost(
            identifiers: $post->getIdentifiers(),
            marketplace: $post->getMarketplace(),
            price: $price,
        );
        $post->setSecondaryPrice(self::getSecondaryPrice($post, $costs, $dimensions, $category));

        return $post;
    }

    private function getSecondaryPrice(Post $post, Costs $costs, Dimensions $dimensions, Category $category): Price
    {
        return $this->calculatePriceService->calculate(
            productData: new ProductData($costs, $dimensions, $category),
            marketplace: $post->getMarketplace(),
            value: MoneyTransformer::toFloat($post->getPrice()->get()),
            commission: Percentage::fromFraction($post->getPrice()->getCommission()->getCommissionRate()),
            options: ['ignoreFreight' => true]
        );
    }
}
