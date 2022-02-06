<?php

namespace Src\Products\Domain\Models\Post\Factories;

use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Math\Percentage;
use Src\Calculator\Domain\Services\Contracts\CalculatorOptions;
use Src\Math\MoneyTransformer;
use Src\Calculator\Domain\Models\Price\Price as CalculatedPrice;
use Src\Calculator\Domain\Models\Product\ProductData;
use Src\Calculator\Application\Services\CalculatePost;
use Src\Calculator\Application\Services\CalculatePrice;
use Src\Prices\Domain\Models\Price as PriceModel;
use Src\Products\Domain\Models\Post\Contracts\Factory as FactoryInterface;
use Src\Products\Domain\Models\Post\MagaluPost;
use Src\Products\Domain\Models\Post\Post;
use Src\Products\Domain\Models\Product\Product;

class Magalu implements FactoryInterface
{
    use WithSecondaryPriceFactory;

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

    public function make(PriceModel $priceModel): Post
    {
        $post = $this->getPostCalculated($priceModel);
        $post->setSecondaryPrice(
            $this->calculatePostService->calculatePost(
                $priceModel,
                $this->getCalculatorOptions()
            )
        );

        return $post;
    }

    public function updatePrice(Post $post, CalculatedPrice $calculatedPrice): Post
    {
        $post = new MagaluPost(
            priceModel: $post->getPriceModel(),
            calculatedPrice: $calculatedPrice
        );

        $post->setSecondaryPrice(
            $this->getSecondaryPriceCalculated(
                $post,
                $this->getCalculatorOptions()
            )
        );

        return $post;
    }

    private function getPostCalculated(PriceModel $priceModel): MagaluPost
    {
        $calculatedPrice = $this->calculatePostService->calculatePost($priceModel);

        return new MagaluPost(
            priceModel: $priceModel,
            calculatedPrice: $calculatedPrice
        );
    }

    private function getCalculatorOptions(): array
    {
        return [CalculatorOptions::DISCOUNT_RATE => Percentage::fromPercentage(5)];
    }
}

