<?php

namespace Src\Products\Domain\Models\Post\Factories;

use Src\Calculator\Application\Services\CalculatePost;
use Src\Prices\Domain\Models\Calculator\Contracts\CalculatedPrice as CalculatedPrice;
use Src\Prices\Infrastructure\Laravel\Models\Price as PriceModel;
use Src\Products\Domain\Models\Post\Contracts\Factory as FactoryInterface;
use Src\Products\Domain\Models\Post\MagaluPost;
use Src\Products\Domain\Models\Post\Post;

class Magalu implements FactoryInterface
{
    private CalculatePost $calculatePostService;

    public function __construct(CalculatePost $calculatePostService)
    {
        $this->calculatePostService = $calculatePostService;
    }

    public function make(PriceModel $priceModel): Post
    {
        $calculatedPrice = $this->calculatePostService->calculatePost($priceModel);

        return new MagaluPost(
            priceModel: $priceModel,
            calculatedPrice: $calculatedPrice
        );
    }

    public function updatePrice(Post $post, CalculatedPrice $calculatedPrice): Post
    {
        return new MagaluPost(
            priceModel: $post->getPriceModel(),
            calculatedPrice: $calculatedPrice
        );
    }
}
