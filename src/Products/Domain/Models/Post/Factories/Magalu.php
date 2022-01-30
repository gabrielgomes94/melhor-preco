<?php

namespace Src\Products\Domain\Models\Post\Factories;

use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Math\Percentage;
use Src\Calculator\Domain\Services\Contracts\CalculatorOptions;
use Src\Math\MoneyTransformer;
use Src\Calculator\Domain\Models\Price\Price;
use Src\Calculator\Domain\Models\Product\ProductData;
use Src\Calculator\Application\Services\CalculatePost;
use Src\Calculator\Application\Services\CalculatePrice;
use Src\Products\Domain\Models\Post\Contracts\Factory as FactoryInterface;
use Src\Products\Domain\Models\Post\Identifiers\Identifiers as PostIdentifiers;
use Src\Products\Domain\Models\Post\MagaluPost;
use Src\Products\Domain\Models\Post\Post;
use Src\Products\Domain\Models\Product\Data\Costs\Costs;
use Src\Products\Domain\Models\Product\Data\Dimensions\Dimensions;

class Magalu implements FactoryInterface
{
    private CalculatePrice $calculatePriceService;
    private CalculatePost $calculatePostService;
    private MarketplaceRepository $marketplaceRepository;

    public function __construct(
        CalculatePrice $calculatePriceService,
        CalculatePost $calculatePostService,
        MarketplaceRepository $marketplaceRepository
    ) {
        $this->calculatePriceService = $calculatePriceService;
        $this->calculatePostService = $calculatePostService;
        $this->marketplaceRepository = $marketplaceRepository;
    }

    public function make(array $data): Post
    {
        $post = $this->getPostCalculated(
            $data,
            $this->calculatePostService->calculate($data)
        );

        $post->setSecondaryPrice(
            $this->calculatePostService->calculate($data, [
                CalculatorOptions::DISCOUNT_RATE => Percentage::fromPercentage(5)
            ])
        );

        return $post;
    }

    public function updatePrice(Post $post, Price $price, Costs $costs, Dimensions $dimensions): Post
    {
        $post = new MagaluPost(
            identifiers: $post->getIdentifiers(),
            marketplace: $post->getMarketplace(),
            price: $price,
        );
        $post->setSecondaryPrice($this->getSecondaryPrice($post, $costs, $dimensions));

        return $post;
    }

    private function getSecondaryPrice(Post $post, Costs $costs, Dimensions $dimensions): Price
    {
        return $this->calculatePriceService->calculate(
            productData: new ProductData($costs, $dimensions),
            marketplace: $post->getMarketplace(),
            value: MoneyTransformer::toFloat($post->getPrice()->get()),
            commission: Percentage::fromFraction($post->getPrice()->getCommission()->getCommissionRate()),
            options: [
                CalculatorOptions::DISCOUNT_RATE => Percentage::fromPercentage(5),
            ]
        );
    }

    private function getPostCalculated(array $data, Price $price): MagaluPost
    {
        $marketplace = $this->marketplaceRepository->getBySlug($data['store']);

        return new MagaluPost(
            identifiers: new PostIdentifiers($data['id'], $data['store_sku_id']),
            marketplace: $marketplace,
            price: $price,
        );
    }
}

